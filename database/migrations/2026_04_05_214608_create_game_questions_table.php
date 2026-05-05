<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('question_order');
            $table->timestamp('answered_at')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->unsignedInteger('earned_points')->default(0);
            $table->unsignedInteger('time_spent')->nullable();
            $table->enum('status', ['pending', 'correct', 'incorrect', 'timeout'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_questions');
    }
};