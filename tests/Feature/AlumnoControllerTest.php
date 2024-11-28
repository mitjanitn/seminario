<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Alumno;

class AlumnoControllerTest extends TestCase
{
    // Refresca la base de datos después de cada prueba
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_alumno()
    {
        $response = $this->post('/alumnos', [
            'name' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'edad' => 20,
        ]);
        // Verifica que redirija a la lista de alumnos
        $response->assertRedirect('/alumnos'); //verifica que regrese al index de alumnos
        $this->assertDatabaseHas('alumnos', [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'edad' => 20,
        ]);
    }

    /** @test */
    //prueba
    public function validar_vista_index(): void 
    {
        $response = $this->get('/alumnos');
        $response->assertStatus(200);
    }

    /** @test */
    public function puede_mostrar_detalles_de_un_alumno()
    {
        //hace un insert aleatorio en base al factory (modelo falso faker)
        $alumno = Alumno::factory()->create();
        
        //dd($alumno); //para ver lo que se esta mandando (en terminal)

        $response = $this->get("/alumnos/{$alumno->id}"); //obtiene el id del alumno
       
        //dd($response);

        $response->assertStatus(200); // Verifica que la solicitud fue exitosa
        $response->assertSee($alumno->nombre);
        $response->assertSee($alumno->apellido);
    }

     /** @test */
    public function puede_actualizar_un_alumno()
    {
 
        //Configuracion de la prueba: Creación de un alumno inicial
        $alumno = Alumno::factory()->create([ //hace el insert especifico
            //como salen los campos en la bd
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'edad' => 20,
        ]);
        //Ejecuta la accion: Enviar una solicitud PUT para actualizar los datos
        $response = $this->put("/alumnos/{$alumno->id}", [
            //como salen los campos en el input
            'nombre' => 'Carlos',
            'apellido' => 'García',
            'email' => 'carlos.garcia@example.com',
            'edad' => 22,
        ]);

        //verifica la redireccion despues de la actualizacion
        $response->assertRedirect('/alumnos');

        $this->assertDatabaseHas('alumnos', [
            //como los campos de la base de datos
            'id' => $alumno->id,       
            'nombre' => 'Carlos',        
            'apellido' => 'García',      
            'email' => 'carlos.garcia@example.com', 
            'edad' => 22,                
        ]);
        $this->assertDatabaseMissing('alumnos', [
            //como los input de la vista
            'id' => $alumno->id,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'edad' => 20,
        ]);
    }

    /** @test */
    public function puede_eliminar_un_alumno()
    {        
        $alumno = Alumno::factory()->create();
        $response = $this->delete("/alumnos/{$alumno->id}");
        $response->assertRedirect('/alumnos');
        $this->assertSoftDeleted('alumnos', [
            'id' => $alumno->id,
        ]);
    }
}

