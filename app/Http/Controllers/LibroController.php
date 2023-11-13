<?php

namespace App\Http\Controllers;

use App\Models\Autors;
use App\Models\Categoria;
use App\Models\Editorials;
use App\Models\Libro;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class LibroController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        $libros = Libro::where('TituloLibro', 'like', '%' . $search . '%')
            ->orWhereHas('autor', function ($query) use ($search) {
                $query->where('NombreAutor', 'like', '%' . $search . '%')
                    ->orWhere('ApellidoAutor', 'like', '%' . $search . '%');
            })
            ->get();
        $autores = Autors::all();
        $categorias = Categoria::all();
        $editoriales = Editorials::all();
        return view('libros.index', compact('libros', 'autores', 'categorias', 'editoriales'));
    }

    public function create()
    {
        $autores = Autors::all();
        $categorias = Categoria::all();
        $editoriales = Editorials::all();
        return view('libros.create', compact('autores', 'categorias', 'editoriales'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TituloLibro' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = Libro::where('TituloLibro', $value)
                        ->where('IdAutor', $request->IdAutor)
                        ->where('IdCategoria', $request->IdCategoria)
                        ->where('IdEditorial', $request->IdEditorial)
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe un libro con el mismo título, autor, categoría y editorial.');
                    }
                },
            ],
            'IdAutor' => 'required|exists:autors,IdAutor',
            'IdCategoria' => 'required|exists:categorias,IdCategoria',
            'IdEditorial' => 'required|exists:editorials,IdEditorial',
            'CantidadLibro' => 'required|numeric|integer|min:0',
            'DescripcionLibro' => 'required',
        ], [
            'TituloLibro.required' => 'Ingrese el título del libro',
            'CantidadLibro.required' => 'Debe ingresar la cantidad del libro',
            'CantidadLibro.integer' => 'La cantidad del libro debe ser un número entero.',
            'DescripcionLibro.required' => 'Debe ingresar una descripción del libro.',
            'CantidadLibro.numeric' => 'Únicamente se aceptan números, no letras.',

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 409);
        }

        try {
            $estadoLibro = $request->input('EstadoLibro', 'Disponible');
            $libro = Libro::create(array_merge($request->all(), ['EstadoLibro' => $estadoLibro]));
            $libro->load('autor', 'categoria', 'editorial');


            return response()->json(['success' => 'Libro creado con éxito!', 'data' => $libro], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear libro'], 500);
        }
    }

    public function show(Libro $libro)
    {
        return view('libros.show', compact('libro'));
    }

    public function edit(Libro $libro)
    {
        $libro->load('autor', 'categoria', 'editorial');
        return response()->json(['success' => true, 'data' => $libro]);
    }

    public function update(Request $request, Libro $libro)
    {
        $validator = Validator::make($request->all(), [

            'TituloLibro' => [
                'required',
                function ($attribute, $value, $fail) use ($request, $libro) {
                    $exists = Libro::where('TituloLibro', $value)
                        ->where('IdAutor', $request->IdAutor)
                        ->where('IdCategoria', $request->IdCategoria)
                        ->where('IdEditorial', $request->IdEditorial)
                        ->where('IdLibro', '!=', $libro->IdLibro) // ignorar el libro actual
                        ->exists();
                    if ($exists) {
                        $fail('Ya existe un libro con el mismo título, autor, categoría y editorial.');
                    }
                },
            ],
            'IdAutor' => 'required|exists:autors,IdAutor',
            'IdCategoria' => 'required|exists:categorias,IdCategoria',
            'IdEditorial' => 'required|exists:editorials,IdEditorial',
            'CantidadLibro' => 'required|numeric|integer|min:0',
            'DescripcionLibro' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 409);
        }


        try {
            $libro->update($request->all());

            // Asegurándonos de que el estado del libro se actualiza basado en la cantidad.
            $cantidadLibro = $request->input('CantidadLibro');
            if ($cantidadLibro > 0) {
                $libro->EstadoLibro = 'Disponible';
            } else {
                $libro->EstadoLibro = 'No Disponible';
            }

            // Guardando explícitamente el cambio de estado.
            $libro->save();

            $libro->load('autor', 'categoria', 'editorial');
            return response()->json(['success' => 'Libro actualizado con éxito!', 'data' => $libro], 200);
        } catch (\Exception $exception) {
            Log::error('Error al actualizar libro: ' . $exception->getMessage());
            return response()->json(['message' => 'Error al actualizar libro'], 500);
        }
    }

    public function destroy($id)
    {
        try {

            $libro = Libro::findOrFail($id);

            // Verificar si el libro está actualmente prestado
            $prestado = Prestamo::where('IdLibro', $id)->where('EstadoPrestamo', 'Prestado')->exists();

            if ($prestado) {
                return response()->json([
                    'error' => 'No se puede eliminar el libro',
                    'message' => 'Este libro está actualmente prestado y no puede ser eliminado.'
                ], 403);
            }

            $libro->delete();
            return response()->json(['success' => 'Libro eliminado con éxito.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Libro no encontrado',
                'message' => 'No se pudo encontrar el libro que intenta eliminar.'
            ], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'error' => 'Error al eliminar',
                'message' => 'Ocurrió un error inesperado al intentar eliminar el libro.'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $libro = Libro::withTrashed()->findOrFail($id);

            // Verificar si existe un libro activo con los mismos detalles
            $exists = Libro::where('TituloLibro', $libro->TituloLibro)
                ->where('IdAutor', $libro->IdAutor)
                ->where('IdCategoria', $libro->IdCategoria)
                ->where('IdEditorial', $libro->IdEditorial)
                ->exists();

            if ($exists) {
                return response()->json([
                    'error' => 'Restauración no permitida',
                    'message' => 'No se puede restaurar el libro porque ya existe un libro activo con los mismos detalles.'
                ], 409);
            }

            $libro->restore();
            return response()->json(['success' => 'Libro restaurado con éxito.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Libro no encontrado',
                'message' => 'No se pudo encontrar el libro que intenta restaurar.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al restaurar',
                'message' => 'Ocurrió un error inesperado al intentar restaurar el libro.'
            ], 500);
        }
    }

    public function librosEliminados()
    {
        $librosEliminados = Libro::onlyTrashed()->get();
        return view('libros.eliminados', compact('librosEliminados'));
    }

    public function librosPrestados()
    {
        $prestamosActivos = Prestamo::where('EstadoPrestamo', 'Prestado')->with('libro', 'usuario')->get();
        return view('libros.librosprestados', compact('prestamosActivos'));
    }

    public function generarReporte($tipo)
    {
        switch ($tipo) {
            case 'disponibles':
                $libros = Libro::where('EstadoLibro', 'Disponible')->whereNull('deleted_at')->get();
                $titulo = 'Reporte de Libros Disponibles';
                break;
            case 'nodisponibles':
                $libros = Libro::where('EstadoLibro', 'No Disponible')->whereNull('deleted_at')->get();
                $titulo = 'Reporte de Libros No Disponibles';
                break;
            case 'eliminados':
                $libros = Libro::onlyTrashed()->get();
                $titulo = 'Reporte de Libros Eliminados';
                break;
            case 'todos':
                $libros = Libro::whereNull('deleted_at')->get();
                $titulo = 'Reporte de Todos los Libros';
                break;
            default:
                abort(404);
        }

        $pdf = FacadePdf::loadView('libros.libroreport', ['libros' => $libros, 'titulo' => $titulo]);
        return $pdf->download('reporte_libros.pdf');
    }
}
