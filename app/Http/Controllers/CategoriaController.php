<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;


class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all(); // Obtener todos los registros sin paginación
        return view('categorias.index', compact('categorias'));
    }

    public function generateReport($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return redirect()->back()->with('error', 'Categoría no encontrada');
        }

        $libros = $categoria->libros; // Asegúrate de tener una relación definida en tu modelo Categoria

        $pdf = PDF::loadView('categorias.reporte_categoria', compact('categoria', 'libros'));
        return $pdf->download('reporte_categoria.pdf');
    }

    public function generateFullReport()
    {
        $categorias = Categoria::all();
        $totalCategorias = $categorias->count();

        $pdf = PDF::loadView('categorias.reporte_completo', compact('categorias', 'totalCategorias'));
        return $pdf->download('reporte_categorias.pdf');
    }


    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreCategoria' => 'required|min:3|max:255|regex:/^[a-zA-Z0-9\s]+$/|unique:categorias',

        ], [
            'NombreCategoria.required' => 'Debe ingresar el nombre de la categoría',
            'NombreCategoria.min' => 'El nombre de la categoría debe tener al menos 3 caracteres',
            'NombreCategoria.max' => 'El nombre de la categoría no debe exceder los 255 caracteres',
            'NombreCategoria.regex' => 'El nombre de la categoría solo debe contener letras y espacios',
            'NombreCategoria.unique' => 'Esta categoría ya existe.',
        ]);

        $exists = Categoria::where('NombreCategoria', $request->NombreCategoria)->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'La categoría ya existe'], 409);
        }

        try {
            $categoria = Categoria::create($request->all());
            return response()->json(['success' => 'Categoría creada con éxito!', 'data' => $categoria], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear categoría'], 500);
        }
    }

    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return response()->json(['success' => true, 'data' => $categoria], 200);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validator = Validator::make($request->all(), [
            'NombreCategoria' => 'required|min:3|max:255|regex:/^[a-zA-Z0-9\s]+$/|unique:categorias,NombreCategoria,' . $categoria->IdCategoria . ',IdCategoria',

            'NombreCategoria.required' => 'Debe ingresar el nombre de la categoría',
            'NombreCategoria.min' => 'El nombre de la categoría debe tener al menos 3 caracteres',
            'NombreCategoria.max' => 'El nombre de la categoría no debe exceder los 255 caracteres',
            'NombreCategoria.regex' => 'El nombre de la categoría solo debe contener letras y espacios',
            'NombreCategoria.unique' => 'Esta categoría ya existe.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Esta categoría ya existe.'], 409);
        }

        try {
            $categoria->update($request->only('NombreCategoria'));
            return response()->json(['success' => 'Categoría actualizada con éxito!', 'data' => $categoria], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al actualizar categoría'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            return response()->json(['success' => 'Categoría eliminada con éxito.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'No se puede eliminar esta categoría porque está vinculada a uno o más libros.'], 403);
        }
    }

}
