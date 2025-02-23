<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id')->nullable(); // Optional: Falls es Timer für Quizze gibt
            $table->unsignedBigInteger('question_id')->nullable(); // Falls jede Frage eine eigene Zeit hat
            $table->integer('time_limit'); // Zeit in Sekunden
            $table->timestamps();
    
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
