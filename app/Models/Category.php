<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}