<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*Habilitar softdeletes*/
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends Model
{
    use HasFactory, SoftDeletes;

    //para este modelo se va a usar tabla alumnos
    protected $table = 'alumnos';

    //campos que pueden ser llenados de forma masiva
    //para que nos puedan ingresar informacion a esos campos
    protected $fillable = ['nombre', 'apellido', 'email', 'edad'];
}

