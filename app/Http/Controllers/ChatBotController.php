<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class ChatBotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }

    public function consultar(Request $request)
    {
        $consulta = $request->input('consulta');
        $endpoint = env('CHATBOT_ENDPOINT', 'http://194.163.45.97/consulta');

        // Crea un nuevo cliente Guzzle
        $client = new Client();

        try {
            // Realiza una petición POST al endpoint de tu chatbot con la consulta
            $response = $client->request('POST', $endpoint, [
                'json' => ['consulta' => $consulta]
            ]);

            // Decodifica la respuesta JSON
            $output = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Maneja la excepción si algo sale mal
            $output = ['error' => $e->getMessage()];
        }

        return response()->json($output);
    }
}
