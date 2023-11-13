<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function buscar(Request $request)

    {

        $term = $request->input('term');
        $tipo = $request->input('tipo');
        $resultados = [];

        switch ($tipo) {
            case 'autor':
                $autores = DB::table('autors')
                    ->where('NombreAutor', 'like', '%' . $term . '%')
                    ->orWhere('ApellidoAutor', 'like', '%' . $term . '%')
                    ->get();
                foreach ($autores as $autor) {
                    $resultados[] = [
                        'label' => $autor->NombreAutor . ' ' . $autor->ApellidoAutor,
                        'value' => $autor->IdAutor
                    ];
                }
                break;
            case 'editorial':
                $editoriales = DB::table('editorials')
                    ->where('NombreEditorial', 'like', '%' . $term . '%')
                    ->get();
                foreach ($editoriales as $editorial) {
                    $resultados[] = [
                        'label' => $editorial->NombreEditorial,
                        'value' => $editorial->IdEditorial
                    ];
                }
                break;
            case 'categoria':
                $categorias = DB::table('categorias')
                    ->where('NombreCategoria', 'like', '%' . $term . '%')
                    ->get();
                foreach ($categorias as $categoria) {
                    $resultados[] = [
                        'label' => $categoria->NombreCategoria,
                        'value' => $categoria->IdCategoria
                    ];
                }
                break;
            case 'libro': 
                $libros = DB::table('libros')
                    ->where('TituloLibro', 'like', '%' . $term . '%')
                    ->whereNull('deleted_at')
                    ->get();
                foreach ($libros as $libro) {
                    $resultados[] = [
                        'label' => $libro->TituloLibro,
                        'value' => $libro->IdLibro
                    ];
                }
                break;
        }


        return response()->json($resultados);
    }
}
