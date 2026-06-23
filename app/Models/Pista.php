<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pista extends Model
{
    protected $table = 'pistas';
    protected $primaryKey = 'idPista';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'idPregunta',
        'pista',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Question::class, 'idPregunta', 'id');
    }
}