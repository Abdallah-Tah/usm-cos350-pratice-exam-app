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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('question_number');
            $table->string('section');
            $table->string('difficulty'); // easy, medium, hard
            $table->text('question_text');
            $table->text('code_snippet')->nullable();
            $table->json('options'); // Array of 4 options
            $table->string('correct_answer'); // a, b, c, or d
            $table->text('explanation');
            $table->text('key_concept')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
