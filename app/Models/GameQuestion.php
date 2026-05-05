<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameQuestion extends Model
{
    protected $fillable = [
        'game_id',
        'question_id',
        'question_order',
        'answered_at',
        'is_correct',
        'earned_points',
        'time_spent',
        'status'
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'is_correct' => 'boolean'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}