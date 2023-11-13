<?php

namespace App\Http\Controllers;

use App\Models\Editorials;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;


class EditorialController extends Controller
{
    public function index()
    {
        $editorials = Editorials::all();
        return view('editorials.index', compact('editorials'));
    }

    public function generateReport($id)
    {
        $editorial = Editorials::find($id);
        if (!$editorial) {
            return redirect()->back()->with('error', 'Editorial no encontrada');
        }

        $libros = $editorial->libros;

        $pdf = PDF::loadView('editorials.reporte_editorial', compact('editorial', 'libros'));
        return $pdf->download('reporte_editorial.pdf');
    }

    public function generateFullReport()
    {
        $editorials = Editorials::with('libros')->get();
        $totalEditorials = Editorials::count();
        $pdf = PDF::loadView('editorials.reporte_completo_editorial', compact('editorials', 'totalEditorials'));
        return $pdf->download('reporte_completo_editorial.pdf');
    }

    public function create()
    {
        return view('editorials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreEditorial' => 'required|regex:/^[\pL\s\d\-]+$/u|min:3|max:255',
        ], [
            'NombreEditorial.required' => 'Debe ingresar el nombre de la editorial',
            'NombreEditorial.regex' => 'El nombre solo debe contener letras, números y espacios',
            'NombreEditorial.min' => 'El nombre debe ser de al menos 3 caracteres',
            'NombreEditorial.max' => 'El nombre no debe exceder los 255 caracteres',
        ]);

        $exists = Editorials::where('NombreEditorial', $request->NombreEditorial)->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'La editorial ya existe'], 409);
        }

        try {
            $categoria = Editorials::create($request->all());
            return response()->json(['success' => 'Editorial creada con éxito!', 'data' => $categoria], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear categoría'], 500);
        }
    }

    public function show(Editorials $editorial)
    {
        return view('editorials.show', compact('editorial'));
    }

    public function edit(Editorials $editorial)
    {
        return response()->json(['success' => true, 'data' => $editorial], 200);
    }

    public function update(Request $request, Editorials $editorial)
    {
        $validator = Validator::make($request->all(), [
            'NombreEditorial' => 'required|regex:/^[\pL\s\d\-]+$/u|min:3|max:255|unique:editorials,NombreEditorial,' . $editorial->IdEditorial . ',IdEditorial',
        ], [
            'NombreEditorial.required' => 'Debe ingresar el nombre de la editorial',
            'NombreEditorial.regex' => 'El nombre solo debe contener letras, números y espacios',
            'NombreEditorial.min' => 'El nombre debe ser de al menos 3 caracteres',
            'NombreEditorial.max' => 'El nombre no debe exceder los 255 caracteres',
            'NombreEditorial.unique' => 'Esta editorial ya existe.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Esta editorial ya existe.'], 409);
        }

        try {
            $editorial->update($request->all());
            return response()->json(['success' => 'Editorial actualizada con éxito!', 'data' => $editorial], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al actualizar editorial'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $editorial = Editorials::findOrFail($id);
            $editorial->delete();

            return response()->json(['success' => 'Editorial eliminada con éxito.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'No se puede eliminar esta editorial porque está vinculada a uno o más libros.'], 403);
        }
    }

}
