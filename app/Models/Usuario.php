<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 

class Usuario extends Authenticatable
{
    use HasApiTokens; // ← agregar este trait

    protected $table = 'usuarios';
    protected $primaryKey = 'idUsuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'password',
        'activo'
    ];

    protected $hidden = [
        'password'
    ];
}