<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function(){
     return view('login');
}); 

Route::get('/registrarUsuario', function(){
     return view('login');
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/iniciar-juego', function () {
    return view('start');
});

Route::get('/jugar', function(){
    return view('play');
});
Route::get('/CrearPista', function(){
    return view('pistaadmin');
});

Route::get('/resultado', function(){
    return view('resultado');

});Route::get('/admin', function () {
    return view('admin');
});
Route::get('/admin', function () {
    return view('admin');
});