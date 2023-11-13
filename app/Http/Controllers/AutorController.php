<?php

namespace App\Http\Controllers;

use App\Models\Autors;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;


class AutorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $autors = Autors::where('NombreAutor', 'like', '%' . $search . '%')
            ->orWhere('ApellidoAutor', 'like', '%' . $search . '%')
            ->get();
        return view('autors.index', compact('autors'));
    }

    public function generateReport($id)
    {
        $autor = Autors::find($id);

        if (!$autor) {
            return redirect()->back()->with('error', 'Autor no encontrado');
        }

        $libros = $autor->libros; 

        $pdf = PDF::loadView('autors.reporte_autor', compact('autor', 'libros'));
        return $pdf->download('reporte_autor.pdf');
    }

    public function generateFullReport()
    {
        $autors = Autors::with('libros')->get();
        $totalAutors = Autors::count();
        $pdf = PDF::loadView('autors.reporte_completo_autor', compact('autors', 'totalAutors'));
        return $pdf->download('reporte_completo_autor.pdf');
    }

    public function create()
    {
        return view('autors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreAutor' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'ApellidoAutor' => 'required|regex:/^[\pL\s\-]+$/u|min:4',
        ], [
            'NombreAutor.required' => 'Debe ingresar el nombre',
            'NombreAutor.alpha' => 'El nombre solo debe contener letras',
            'NombreAutor.min' => 'El nombre debe ser de al menos 3 caracteres',
            'ApellidoAutor.required' => 'Debe ingresar el apellido',
            'ApellidoAutor.alpha' => 'El apellido solo debe contener letras',
            'ApellidoAutor.min' => 'El apellido debe ser de al menos 4 caracteres',
        ]);

        $exists = Autors::where('NombreAutor', $request->NombreAutor)
            ->where('ApellidoAutor', $request->ApellidoAutor)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'El autor ya existe'], 409);
        }

        try {
            $autor = Autors::create($request->all());
            return response()->json(['success' => 'Autor creado con éxito!', 'data' => $autor], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear autor'], 500);
        }
    }


    public function show(Autors $autor)
    {
        return view('autors.show', compact('autor'));
    }

    public function edit(Autors $autor)
    {
        return response()->json(['success' => true, 'data' => $autor], 200);
    }

    public function update(Request $request, Autors $autor)
    {
        $validator = Validator::make($request->all(), [
            'NombreAutor' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'ApellidoAutor' => 'required|regex:/^[\pL\s\-]+$/u|min:4',
        ], [
            'NombreAutor.required' => 'Debe ingresar el nombre',
            'NombreAutor.alpha' => 'El nombre solo debe contener letras',
            'NombreAutor.min' => 'El nombre debe ser de al menos 3 caracteres',
            'ApellidoAutor.required' => 'Debe ingresar el apellido',
            'ApellidoAutor.alpha' => 'El apellido solo debe contener letras',
            'ApellidoAutor.min' => 'El apellido debe ser de al menos 4 caracteres',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 409);
        }

        // Validación para verificar si el autor ya existe
        $exists = Autors::where('NombreAutor', $request->NombreAutor)
            ->where('ApellidoAutor', $request->ApellidoAutor)
            ->where('IdAutor', '!=', $autor->IdAutor) // Excluyendo el autor actual
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'No se puede actualizar el autor porque ya existe.'], 409);
        }

        try {
            $autor->update($request->all());
            return response()->json(['success' => 'Autor actualizado con éxito!', 'data' => $autor], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al actualizar autor'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $autor = Autors::findOrFail($id);
            $autor->delete();

            return response()->json(['success' => 'Autor eliminado con éxito.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'No se puede eliminar este autor porque está vinculado a uno o más libros.'], 403);
        }
    }


    public function search(Request $request)
    {
        $query = $request->get('query');
        $autors = Autors::where('NombreAutor', 'like', '%' . $query . '%')
            ->orWhere('ApellidoAutor', 'like', '%' . $query . '%')
            ->get();
        return response()->json($autors);
    }


}