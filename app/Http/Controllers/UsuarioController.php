<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function generateCustomReport(Request $request)
    {
        $tipo = $request->get('tipo');
        $valor = $request->get('valor');

        $query = Usuario::query();

        if ($tipo === 'direccion') {
            $query->where('DireccionUsuario', 'like', '%' . $valor . '%');
        } elseif ($tipo === 'estudiante') {
            if ($valor === 'todos') {
                $query->where('GradoUsuario', '!=', 'No aplica');
            } else {
                $query->where('GradoUsuario', $valor);
            }
        } elseif ($tipo === 'comunidad') {
            $query->where('GradoUsuario', 'No aplica');
        } elseif ($tipo === 'todos') {
        }

        $usuarios = $query->get();

        $pdf = FacadePdf::loadView('usuarios.reportselect', compact('usuarios'));
        return $pdf->download('reporte_usuarios_personalizado.pdf');
    }

    public function generateReport($id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $pdf = FacadePdf::loadView('usuarios.reporte_usuario', compact('usuario'));
        return $pdf->download('reporte_usuario.pdf');
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'NombreUsuario' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'ApellidoUsuario' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'DireccionUsuario' => 'required|string|max:255',
            'TelefonoUsuario' => 'required|regex:/^[0-9]{7,10}$/',
            'GradoUsuario' => 'required_if:tipoUsuario,Escuela',
        ], [
            'NombreUsuario.required' => 'Debe ingresar el nombre',
            'NombreUsuario.regex' => 'El nombre solo debe contener letras y espacios',
            'NombreUsuario.min' => 'El nombre debe ser de al menos 3 caracteres',
            'ApellidoUsuario.required' => 'Debe ingresar el apellido',
            'ApellidoUsuario.regex' => 'El apellido solo debe contener letras y espacios',
            'ApellidoUsuario.min' => 'El apellido debe ser de al menos 3 caracteres',
            'DireccionUsuario.required' => 'Debe ingresar la dirección',
            'TelefonoUsuario.required' => 'Debe ingresar el teléfono',
            'TelefonoUsuario.regex' => 'El teléfono debe tener entre 7 y 10 dígitos',
            'GradoUsuario.required_if' => 'Debe ingresar el grado si el tipo de usuario es Escuela',
        ]);

        try {
            // Genera el CodigoUsuario antes de crear el usuario
            $codigoUsuario = substr($request->NombreUsuario, 0, 2) . $request->ApellidoUsuario;
            $usuarioData = array_merge($request->all(), ['CodigoUsuario' => $codigoUsuario]);
            $usuario = Usuario::create($usuarioData);

            // Obtenemos el IdUsuario, genera el CodigoUsuario final y actualiza el usuario
            $codigoUsuarioFinal = $codigoUsuario . $usuario->IdUsuario;

            $usuario->update(['CodigoUsuario' => $codigoUsuarioFinal]);
            return response()->json(['success' => 'Usuario creado con éxito!', 'data' => $usuario], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al crear usuario'], 500);
        }
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return response()->json(['success' => true, 'data' => $usuario], 200);
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'NombreUsuario' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'ApellidoUsuario' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'DireccionUsuario' => 'required|string|max:255',
            'TelefonoUsuario' => 'required|regex:/^[0-9]{7,10}$/',
            'GradoUsuario' => 'required_if:tipoUsuario,Escuela',
        ], [
            'NombreUsuario.required' => 'Debe ingresar el nombre',
            'NombreUsuario.regex' => 'El nombre solo debe contener letras y espacios',
            'NombreUsuario.min' => 'El nombre debe ser de al menos 3 caracteres',
            'ApellidoUsuario.required' => 'Debe ingresar el apellido',
            'ApellidoUsuario.regex' => 'El apellido solo debe contener letras y espacios',
            'ApellidoUsuario.min' => 'El apellido debe ser de al menos 3 caracteres',
            'DireccionUsuario.required' => 'Debe ingresar la dirección',
            'TelefonoUsuario.required' => 'Debe ingresar el teléfono',
            'TelefonoUsuario.regex' => 'El teléfono debe tener entre 7 y 10 dígitos',
            'GradoUsuario.required_if' => 'Debe ingresar el grado si el tipo de usuario es Escuela',
        ]);

        try {
            // Genera el CodigoUsuario antes de actualizar el usuario
            $codigoUsuario = substr($request->NombreUsuario, 0, 2) . $request->ApellidoUsuario . $usuario->IdUsuario;
            $usuarioData = array_merge($request->all(), ['CodigoUsuario' => $codigoUsuario]);
            $usuario->update($usuarioData);

            return response()->json(['success' => 'Usuario actualizado con éxito!', 'data' => $usuario], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error al actualizar usuario'], 500);
        }
    }

    public function destroy(Usuario $usuario)
    {
        // Comprobar si el usuario tiene préstamos activos
        if ($usuario->prestamos()->where('EstadoPrestamo', 'Prestado')->exists()) {
            return response()->json(['error' => 'El usuario no puede ser eliminado porque tiene un préstamo activo'], 409);
        }

        try {
            $usuario->delete();
            return response()->json(['success' => 'Usuario eliminado con éxito!'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Error al eliminar usuario'], 500);
        }
    }


    public function buscarPorCodigo($codigo)
    {
        $usuarios = Usuario::where('CodigoUsuario', 'like', "%{$codigo}%")->get();
        if ($usuarios->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No existe un usuario con ese código']);
        }
        return response()->json(['success' => true, 'data' => $usuarios]);
    }
}
