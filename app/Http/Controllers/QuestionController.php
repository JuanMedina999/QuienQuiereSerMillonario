<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json([
                'error' => 'Debes enviar un parámetro de búsqueda'
            ], 400);
        }

        $questions = Question::with([
            'category',
            'answers'
        ])
        ->where('question', 'LIKE', "%{$query}%")
        ->get();

        return response()->json($questions);
    }

   public function index()
{
    return response()->json(
        Category::with([
            'questions.answers'
        ])
        ->orderBy('name')
        ->get()
    );
}

    public function listarPreguntas(Request $request)
    {
        return view('questions');
    }

    public function show($id)
    {
        return response()->json(
            Question::with([
                'category',
                'answers'
            ])->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'points' => 'required|integer|min:0',
            'time_limit' => 'required|integer|min:10',
            'answers' => 'required|array|min:4',
            'answers.*.text' => 'required|string',
            'correct_index' => 'required|integer|min:0'
        ]);

        if ($request->correct_index >= count($request->answers)) {
            return response()->json([
                'error' => 'Índice inválido'
            ], 422);
        }

        return DB::transaction(function () use ($request) {

            $question = Question::create([
                'question' => $request->question,
                'category_id' => $request->category_id,
                'points' => $request->points,
                'time_limit' => $request->time_limit
            ]);

            foreach ($request->answers as $index => $ans) {

                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => $ans['text'],
                    'is_correct' => $index == $request->correct_index
                ]);

            }

            return response()->json([
                'message' => 'Pregunta creada correctamente',
                'data' => $question->load([
                    'category',
                    'answers'
                ])
            ], 201);
        });
    }
   public function update(Request $request, $id)
{
    $question = Question::with('answers')->findOrFail($id);

    $request->validate([
        'question' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'points' => 'required|integer|min:0',
        'time_limit' => 'required|integer|min:10',
        'answers' => 'required|array|min:4',
        'answers.*.text' => 'required|string',
        'correct_index' => 'required|integer|min:0'
    ]);

    DB::transaction(function () use ($request, $question) {

        $question->update([
            'question' => $request->question,
            'category_id' => $request->category_id,
            'points' => $request->points,
            'time_limit' => $request->time_limit
        ]);

        foreach ($question->answers as $index => $answer) {

            $answer->update([
                'answer_text' => $request->answers[$index]['text'],
                'is_correct' => $index == $request->correct_index
            ]);
        }

    });

    return response()->json([
        'message' => 'Pregunta actualizada correctamente'
    ]);
}
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        return response()->json([
            'message' => 'Pregunta eliminada'
        ]);
    }

    public function checkAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id'
        ]);

        $answer = Answer::where('id', $request->answer_id)
            ->where('question_id', $request->question_id)
            ->first();

        if (!$answer) {
            return response()->json([
                'error' => 'Respuesta no válida'
            ], 404);
        }

        return response()->json([
            'correct' => $answer->is_correct
        ]);
    }
    public function porCategoria($categoria_id)
{
    $questions = Question::with(['answers'])
        ->where('category_id', $categoria_id)
        ->get();

    if ($questions->isEmpty()) {
        return response()->json([
            'message' => 'No hay preguntas para esta categoría',
            'data' => []
        ], 200);
    }

    return response()->json([
        'message' => 'Preguntas encontradas',
        'data' => $questions
    ], 200);
}
}