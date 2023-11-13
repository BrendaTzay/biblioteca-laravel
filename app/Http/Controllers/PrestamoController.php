<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Libro;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\PDF;


class PrestamoController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->get('search');
        $prestamos = Prestamo::whereHas('usuario', function ($query) use ($search) {
            $query->where('NombreUsuario', 'like', '%' . $search . '%')
                ->orWhere('ApellidoUsuario', 'like', '%' . $search . '%');
        })
            ->orWhereHas('libro', function ($query) use ($search) {
                $query->where('TituloLibro', 'like', '%' . $search . '%');
            })
            ->get();

        $usuarios = Usuario::all();
        $libros = Libro::all();

        return view('prestamos.index', compact('prestamos', 'usuarios', 'libros'));
    }

    public function generateReport($id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return redirect()->back()->with('error', 'Préstamo no encontrado');
        }

        $pdf = FacadePdf::loadView('prestamos.reporte_prestamo', compact('prestamo'));
        return $pdf->download('reporte_prestamo.pdf');
    }

    public function create()
    {
        return view('prestamos.create');
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        $request->validate([
            'IdUsuario' => 'required|exists:usuarios,IdUsuario',
            'IdLibro' => 'required|exists:libros,IdLibro',
            'FechaSalida' => 'required|date',
            'FechaDevolucion' => 'required|date|after_or_equal:FechaSalida',
            'ObservacionPrestamo' => 'nullable',
        ]);

        try {

            //Verifica si el libro esta disponible para el prestamo
            $libro = Libro::find($request->IdLibro);
            if ($libro->CantidadLibro <= 0) {
                return response()->json(['error' => 'Libro no disponible para préstamo'], 400);
            }

            $request->merge(['EstadoPrestamo' => 'Prestado']);
            $prestamo = Prestamo::create($request->all());
            $prestamo->load('usuario', 'libro');

            //Obtiene el libro y actualiza su stock y estado

            $libro = Libro::find($request->IdLibro);
            $libro->CantidadLibro -= 1;
            $libro->EstadoLibro = $libro->CantidadLibro > 0 ? 'Disponible' : 'No Disponible';
            $libro->save();

            return response()->json(['success' => 'Préstamo creado con éxito!', 'data' => $prestamo], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear préstamo'], 500);
        }
    }

    public function show(Prestamo $prestamo)
    {
        return view('prestamos.show', compact('prestamo'));
    }

    public function edit(Prestamo $prestamo)
    {
        $prestamo->load('libro', 'usuario');
        return response()->json(['success' => true, 'data' => $prestamo], 200);
    }

    public function update(Request $request, Prestamo $prestamo)
    {
        $validator = Validator::make($request->all(), [
            'IdUsuario' => 'required|exists:usuarios,IdUsuario',
            'IdLibro' => 'required|exists:libros,IdLibro',
            'FechaSalida' => 'required|date',
            'FechaDevolucion' => 'required|date|after_or_equal:FechaSalida',
            'EstadoPrestamo' => 'required',
            'ObservacionPrestamo' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validación fallida.'], 409);
        }

        try {

            $prestamo->update($request->all());
            $prestamo->load('libro', 'usuario');

            //busca el libro y actualiza su stock y estaod en el estado de prestamo
            $libro = Libro::find($request->IdLibro);
            if ($request->EstadoPrestamo == 'Devuelto') {
                $libro->CantidadLibro += 1;
            }
            $libro->EstadoLibro = $libro->CantidadLibro > 0 ? 'Disponible' : 'No Disponible';
            $libro->save();

            return response()->json(['success' => 'Préstamo actualizado con éxito!', 'data' => $prestamo], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al actualizar préstamo'], 500);
        }
    }

    public function destroy(Prestamo $prestamo)
    {
        try {
            $prestamo->delete();
            return response()->json(['success' => 'Préstamo eliminado con éxito!'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al eliminar préstamo'], 500);
        }
    }

    public function generarReporte(Request $request)
    {
        $tipo = $request->input('tipo');
        $titulo = '';

        switch ($tipo) {
            case 'devuelto':
                $prestamos = Prestamo::where('EstadoPrestamo', 'Devuelto')->get();
                $titulo = 'Reporte de Préstamos Devueltos';
                break;
            case 'prestado':
                $prestamos = Prestamo::where('EstadoPrestamo', 'Prestado')->get();
                $titulo = 'Reporte de Préstamos Prestados';
                break;
            case 'todos':
                $prestamos = Prestamo::all();
                $titulo = 'Reporte de Todos los Préstamos';
                break;
            default:
                abort(404);
        }

        $pdf = FacadePdf::loadView('prestamos.prestamoreporte', ['prestamos' => $prestamos, 'titulo' => $titulo]);
        return $pdf->download('reporte_prestamos.pdf');
    }

    public function devolver($id)
    {
        $prestamo = Prestamo::find($id);
        if (!$prestamo) {
            return response()->json(['message' => 'Préstamo no encontrado'], 404);
        }

        // Obtenemos el libro relacionado con el préstamo
        $libro = Libro::find($prestamo->IdLibro); 

        if (!$libro) {
            return response()->json(['message' => 'Libro no encontrado'], 404);
        }

        // Incrementamos la cantidad del libro y actualizamos el estado
        $libro->CantidadLibro += 1;
        $libro->EstadoLibro = ($libro->CantidadLibro > 0) ? 'Disponible' : 'No Disponible';

        $libro->save();

        // Actualizamos el estado del préstamo
        $prestamo->EstadoPrestamo = 'Devuelto';
        $prestamo->save();

        return response()->json(['message' => 'Préstamo devuelto con éxito y libro actualizado']);
    }
}
