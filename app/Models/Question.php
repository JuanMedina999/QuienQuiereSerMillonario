<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'category_id',
        'question',
        'points',
        'time_limit'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function gameQuestions()
    {
        return $this->hasMany(GameQuestion::class);
    }
}