<?php

// app/Http/Controllers/LeaderboardController.php
namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function updateScore(Request $request)
    {
        $score = $request->input('score');
        $userId = $request->input('user_id');
        $quizId = $request->input('quiz_id');

        $leaderboard = Leaderboard::updateOrCreate(
            ['user_id' => $userId, 'quiz_id' => $quizId],
            ['score' => $score]
        );

        return response()->json($leaderboard);
    }
}
