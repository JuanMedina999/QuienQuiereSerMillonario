<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'category_id',
        'total_questions',
        'current_question_index',
        'score',
        'status',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gameQuestions()
    {
        return $this->hasMany(GameQuestion::class);
    }
}