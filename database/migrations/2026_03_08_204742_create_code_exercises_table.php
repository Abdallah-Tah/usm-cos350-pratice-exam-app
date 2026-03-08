<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('code_exercises', function (Blueprint $table) {
            $table->id();
            $table->integer('exercise_number');
            $table->string('title');
            $table->string('category'); // strings, pointers, file_io, etc.
            $table->string('difficulty'); // easy, medium, hard
            $table->text('description');
            $table->text('instructions');
            $table->text('starter_code')->nullable();
            $table->text('solution_code');
            $table->json('test_cases'); // Array of test cases
            $table->text('hints')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_exercises');
    }
};
