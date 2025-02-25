<?php
// routes/api.php
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/random', [QuestionController::class, 'getRandomQuestions']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/rules', [RuleController::class, 'index']);
Route::post('/questions/{id}/validate', [QuestionController::class, 'validateAnswer']);
Route::post('/leaderboards/update', [LeaderboardController::class, 'updateScore']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed', // password_confirmation Feld erforderlich
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Verschlüsseltes Passwort
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Registrierung erfolgreich',
        'token' => $token
    ]);
});
Route::middleware('auth:sanctum')->post('questions', [QuestionController::class, 'store']);
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('quizarena-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out']);
});

?>