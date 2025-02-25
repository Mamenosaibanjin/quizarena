<?php
// app/Http/Controllers/QuestionController.php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer; // Model für Antworten
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return response()->json(Question::with('answers')->get());
    }

    public function getRandomQuestions()
    {
        $questions = Question::inRandomOrder()->take(10)->get(); // Hole 10 zufällige Fragen
        return response()->json($questions);
    }

    public function validateAnswer(Request $request, $questionId)
    {
        $question = Question::find($questionId);

        // Angenommene Antwort vom Benutzer
        $userAnswer = $request->input('answer');

        // Validierung
        if ($userAnswer == $question->correct_answer) {
            return response()->json(['correct' => true, 'message' => 'Correct Answer']);
        } else {
            return response()->json(['correct' => false, 'message' => 'Wrong Answer']);
        }
    }

    public function store(Request $request)
    {
        // Validierung der eingehenden Daten
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'rule_id' => 'required|exists:rules,id',
            'question_text' => 'required|string',
            'type' => 'required|in:text,multiple_choice',
            'answers' => 'required|array|min:1', // Validierung der Antworten (mindestens eine Antwort)
            'answers.*.text' => 'required|string', // Jede Antwort sollte einen Text haben
            'answers.*.is_correct' => 'required|boolean', // Jede Antwort sollte einen Wahrheitswert für die Richtigkeit haben
        ]);

        // Frage speichern
        $question = Question::create([
            'category_id' => $validated['category_id'],
            'rule_id' => $validated['rule_id'],
            'question_text' => $validated['question_text'],
            'type' => $validated['type'],
        ]);

        // Antworten speichern
        foreach ($validated['answers'] as $answerData) {
            // Speichern jeder Antwort
            Answer::create([
                'question_id' => $question->id,
                'text' => $answerData['text'],
                'is_correct' => $answerData['is_correct'],
            ]);
        }

        return response()->json($question->load('answers'), 201); // Antwort inklusive der verbundenen Antworten zurückgeben
    }
}
