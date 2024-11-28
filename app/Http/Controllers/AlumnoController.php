<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*modelos*/
use App\Models\Alumno;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::all(); /*select * from alumnos */
        /*$alumnos = Alumno::withTrasehd()->get();*/ /*ver registros eliminados con softdeletes */
        /*dd($alumnos);*/ /*dd = drop and die */
        return view('alumnos.index', compact('alumnos')); /*Retorna la vista de alumnos*/
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /*Para que lleve a la vista de create */
        return view('alumnos.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*dd($request);*/
        /*Para guardar */
        $request->validate([
            'name' => 'required|string|max:20',
            'apellido' => 'required|string|max:20',
            'email' => 'required|email',
            'edad' => 'required|integer|min:1|max:100'
        ]);
        Alumno::create([
            /*nombres que tienen los campos en la bd */
            'nombre' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'edad' => $request->edad
        ]);
        return redirect()->route('alumnos.index')
                         ->with('success', 'Item creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        /*dd($alumno);*/
        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /*Muestra la vista*/
        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $alumno = Alumno::findOrFail($id);
        // Validar los datos, asegurando que el email sea único, excepto para el alumno actual
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:alumnos,email,' . $alumno->id,
            'edad' => 'required|integer',
        ]);
        // Actualizar los datos del alumno
        $alumno->update($request->all());
        // Redireccionar con mensaje de éxito
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
