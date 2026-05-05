<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/iniciar-juego', function () {
    return view('start');
});

Route::get('/jugar', function(){
    return view('play');
});

Route::get('/resultado', function(){
    return view('resultado');

});