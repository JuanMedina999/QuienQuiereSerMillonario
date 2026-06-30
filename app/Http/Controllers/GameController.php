<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Answer;
use App\Models\Question;
use App\Models\GameQuestion;
use Illuminate\Http\Request;

class GameController extends Controller
{
    
    public function start(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id'
    ]);

    $questions = Question::where(
            'category_id',
            $request->category_id
        )
        ->inRandomOrder()
        ->limit(10)
        ->get();

    if ($questions->count() < 1) {

        return response()->json([
            'error' => 'No hay suficientes preguntas en esta categoría. Deben existir al menos 10.'
        ], 422);

    }

    $game = Game::create([
        'category_id' => $request->category_id,
        'total_questions' => 10,
        'current_question_index' => 0,
        'score' => 0,
        'status' => 'playing',
        'started_at' => now()
    ]);

    foreach ($questions as $index => $question) {

        GameQuestion::create([
            'game_id' => $game->id,
            'question_id' => $question->id,
            'question_order' => $index + 1,
            'status' => 'pending'
        ]);

    }

    return response()->json([
        'message' => 'Juego iniciado correctamente',
        'game_id' => $game->id,
        'category_id' => $request->category_id
    ], 201);
}

    public function currentQuestion(Game $game)
    {
        if ($game->status === 'finished') {
            return response()->json([
                'message' => 'El juego ya terminó'
            ], 422);
        }

        $gameQuestion = $game->gameQuestions()
            ->where('question_order', $game->current_question_index + 1)
            ->with('question.answers')
            ->first();

        if (!$gameQuestion) {
            return response()->json([
                'message' => 'No hay más preguntas'
            ], 404);
        }

        $question = $gameQuestion->question;

        return response()->json([
            'game_id' => $game->id,
            'question_number' => $gameQuestion->question_order,
            'question_id' => $question->id,
            'question' => $question->question,
            'points' => $question->points,
            'time_limit' => $question->time_limit,
            'answers' => $question->answers->map(function ($answer) {
                return [
                    'id' => $answer->id,
                    'answer_text' => $answer->answer_text
                ];
            })->values()
        ]);
    }

    public function answer(Request $request, Game $game)
    {
        $request->validate([
            'answer_id' => 'required|exists:answers,id',
            'time_spent' => 'required|integer|min:0'
        ]);

        if ($game->status === 'finished') {
            return response()->json([
                'message' => 'El juego ya terminó'
            ], 422);
        }

        $gameQuestion = $game->gameQuestions()
            ->where('question_order', $game->current_question_index + 1)
            ->with('question.answers')
            ->first();

        if (!$gameQuestion) {
            return response()->json([
                'message' => 'Pregunta actual no encontrada'
            ], 404);
        }

        if ($gameQuestion->status !== 'pending') {
            return response()->json([
                'message' => 'Esta pregunta ya fue respondida o finalizada'
            ], 422);
        }

        $question = $gameQuestion->question;

        $answer = Answer::where('id', $request->answer_id)
            ->where('question_id', $question->id)
            ->first();

        if (!$answer) {
            return response()->json([
                'error' => 'La respuesta no pertenece a la pregunta actual'
            ], 422);
        }

        $earnedPoints = 0;
        $status = 'incorrect';
        $isCorrect = false;

        if ($request->time_spent > $question->time_limit) {
            $status = 'timeout';
        } elseif ($answer->is_correct) {
            $status = 'correct';
            $isCorrect = true;
            $earnedPoints = $question->points;
            $game->score += $earnedPoints;
        }

        $gameQuestion->update([
            'answered_at' => now(),
            'is_correct' => $isCorrect,
            'earned_points' => $earnedPoints,
            'time_spent' => $request->time_spent,
            'status' => $status
        ]);

        $game->current_question_index++;

        if ($game->current_question_index >= $game->total_questions) {
            $game->status = 'finished';
            $game->finished_at = now();
        }

      $game->save();

// Buscar la siguiente pregunta
$nextGameQuestion = $game->gameQuestions()
    ->where('question_order', $game->current_question_index + 1)
    ->with('question.answers')
    ->first();

// Si ya no hay más preguntas
if (!$nextGameQuestion) {
    return response()->json([
        'message' => 'Juego finalizado',
        'result' => $status,
        'earned_points' => $earnedPoints,
        'total_score' => $game->score,
        'game_status' => $game->status
    ]);
}

$nextQuestion = $nextGameQuestion->question;

// Respuesta + siguiente pregunta
return response()->json([
    'message' => 'Respuesta procesada correctamente',
    'result' => $status,
    'earned_points' => $earnedPoints,
    'total_score' => $game->score,
    'game_status' => $game->status,

    'next_question' => [
        'question_number' => $nextGameQuestion->question_order,
        'question_id' => $nextQuestion->id,
        'question' => $nextQuestion->question,
        'points' => $nextQuestion->points,
        'time_limit' => $nextQuestion->time_limit,
        'answers' => $nextQuestion->answers->map(function ($answer) {
            return [
                'id' => $answer->id,
                'answer_text' => $answer->answer_text
            ];
        })->values()
    ]
]);
    }

    public function timeout(Game $game)
    {
        if ($game->status === 'finished') {
            return response()->json([
                'message' => 'El juego ya terminó'
            ], 422);
        }

        $gameQuestion = $game->gameQuestions()
            ->where('question_order', $game->current_question_index + 1)
            ->first();

        if (!$gameQuestion) {
            return response()->json([
                'message' => 'Pregunta actual no encontrada'
            ], 404);
        }

        if ($gameQuestion->status !== 'pending') {
            return response()->json([
                'message' => 'Esta pregunta ya fue respondida o finalizada'
            ], 422);
        }

        $gameQuestion->update([
            'answered_at' => now(),
            'is_correct' => false,
            'earned_points' => 0,
            'status' => 'timeout'
        ]);

        $game->current_question_index++;

        if ($game->current_question_index >= $game->total_questions) {
            $game->status = 'finished';
            $game->finished_at = now();
        }

        $game->save();

        return response()->json([
            'message' => 'Tiempo agotado',
            'total_score' => $game->score,
            'game_status' => $game->status
        ]);
    }

    public function result(Game $game)
    {
        return response()->json([
            'game_id' => $game->id,
            'score' => $game->score,
            'status' => $game->status,
            'questions' => $game->gameQuestions()
                ->with('question.answers')
                ->orderBy('question_order')
                ->get()
        ]);
    }
public function fiftyFifty(Request $request)
{
    $game = Game::findOrFail($request->game_id);

    if ($game->fifty_fifty_used >= 2) {
        return response()->json([
            'success' => false,
            'message' => 'Ya usaste el comodín 50/50 2 veces'
        ], 400);
    }

    // 🔥 USAR TU SISTEMA REAL DE PREGUNTAS
    $gameQuestion = $game->gameQuestions()
        ->where('question_order', $game->current_question_index + 1)
        ->with('question.answers')
        ->first();

    if (!$gameQuestion) {
        return response()->json([
            'success' => false,
            'message' => 'No se encontró la pregunta actual'
        ], 404);
    }

    $question = $gameQuestion->question;

    $answers = $question->answers;

    // respuesta correcta
    $correct = $answers->where('is_correct', 1)->first();

    if (!$correct) {
        return response()->json([
            'success' => false,
            'message' => 'No hay respuesta correcta configurada'
        ], 422);
    }

    // eliminar 2 incorrectas
    $incorrect = $answers->where('is_correct', 0)->shuffle()->take(2);

    $remaining = $answers->diff($incorrect)->values();

    $game->fifty_fifty_used++;
    $game->save();

    return response()->json([
        'success' => true,
        'remaining_options' => $remaining->map(function ($a) {
            return [
                'id' => $a->id,
                'answer_text' => $a->answer_text
            ];
        }),
        'uses_left' => 2 - $game->fifty_fifty_used
    ]);
}

public function cambiarPregunta(Request $request, Game $game)
{
    if ($game->status === 'finished') {
        return response()->json(['message' => 'El juego ya terminó'], 422);
    }

    if ($game->cambio_pregunta_usado) {
        return response()->json(['message' => 'Ya usaste el comodín de cambio de pregunta'], 422);
    }

    $gameQuestion = $game->gameQuestions()
        ->where('question_order', $game->current_question_index + 1)
        ->first();

    if (!$gameQuestion) {
        return response()->json(['message' => 'Pregunta no encontrada'], 404);
    }

    // Obtener IDs de preguntas ya usadas en esta partida
    $usedIds = $game->gameQuestions()->pluck('question_id')->toArray();

    // Buscar una pregunta nueva de la misma categoría
    $nuevaPregunta = Question::where('category_id', $game->category_id)
        ->whereNotIn('id', $usedIds)
        ->inRandomOrder()
        ->first();

    if (!$nuevaPregunta) {
        return response()->json(['message' => 'No hay preguntas disponibles para cambiar'], 422);
    }

    // Reemplazar la pregunta actual
    $gameQuestion->update([
        'question_id' => $nuevaPregunta->id,
        'status' => 'pending'
    ]);

    $game->cambio_pregunta_usado = true;
    $game->save();

    return response()->json([
        'message' => 'Pregunta cambiada correctamente',
        'question_number' => $gameQuestion->question_order,
        'question_id' => $nuevaPregunta->id,
        'question' => $nuevaPregunta->question,
        'points' => $nuevaPregunta->points,
        'time_limit' => $nuevaPregunta->time_limit,
        'answers' => $nuevaPregunta->answers->map(function ($answer) {
            return [
                'id' => $answer->id,
                'answer_text' => $answer->answer_text
            ];
        })->values()
    ], 200);
}
}