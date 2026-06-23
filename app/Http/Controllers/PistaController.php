<?php

namespace App\Http\Controllers;

use App\Models\Pista;
use Illuminate\Http\Request;

class PistaController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'idPregunta' => 'required|exists:questions,id',
            'pista' => 'required|string|max:255',
        ]);

        $pista = Pista::create([
            'idPregunta' => $request->idPregunta,
            'pista'      => $request->pista,
        ]);

        return response()->json([
            'message' => 'Pista creada correctamente',
            'data'    => $pista
        ], 201);
    }

   public function usarPista(Request $request, $idPregunta)
{
    $gameId = $request->query('game_id');

    if (!$gameId) {
        return response()->json(['message' => 'game_id requerido'], 422);
    }

    $game = \App\Models\Game::find($gameId);

    if (!$game) {
        return response()->json(['message' => 'Juego no encontrado'], 404);
    }

    if ($game->pista_usada) {
        return response()->json(['message' => 'Ya usaste el comodín pista en esta partida'], 422);
    }

    $pista = Pista::where('idPregunta', $idPregunta)->first();

    if (!$pista) {
        return response()->json(['message' => 'Esta pregunta no tiene pista'], 404);
    }

    // Marcar pista como usada
    $game->pista_usada = true;
    $game->save();

    return response()->json([
        'message' => 'Pista encontrada',
        'data'    => $pista
    ], 200);
}

}