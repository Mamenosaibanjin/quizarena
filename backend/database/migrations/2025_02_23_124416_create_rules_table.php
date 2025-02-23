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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // z. B. "Schnelle Antwort Bonus"
            $table->text('description')->nullable();
            $table->string('condition')->nullable(); // z. B. "answered_in < 10s"
            $table->integer('points')->default(0); // Punktezuweisung
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};
