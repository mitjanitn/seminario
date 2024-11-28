<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    return view('welcome');
});

//Ruta de tipo resource
Route::resource('alumnos', AlumnoController::class);