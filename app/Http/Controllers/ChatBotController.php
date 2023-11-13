<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ChatBotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function consultar(Request $request)
    {
        $consulta = $request->input('consulta');

        // Ruta según la ubicación real de tu script en modo variable de entorno
        $scriptPath = env('CHATBOT_SCRIPT_PATH');
        // Ruta del intérprete de Python en el entorno virtual
        $pythonPath = env('PYTHON_ENV_PATH');
        $process = new Process([$pythonPath, $scriptPath, escapeshellarg($consulta)]);

        // Aumenta el tiempo límite del proceso (en segundos)
        $process->setTimeout(130);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = json_decode($process->getOutput(), true);
        return response()->json($output);
    }
}
