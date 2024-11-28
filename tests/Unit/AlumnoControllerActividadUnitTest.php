<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\Alumno;
use App\Http\Controllers\AlumnoController;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AlumnoControllerActividadUnitTest extends TestCase
{
    public function test_probar_destory_assertFalse(): void
    {
        $controller = new AlumnoController;

        $alumno = Alumno::create([
            'nombre' => 'Androide',
            'apellido' => 'Número 18',
            'email' => 'numero@correo.com',
            'edad' => '21'
        ]);

        $request = Request::create("/alumno/{$alumno->id}", 'DELETE');
        $response = $controller->destroy($alumno);
        $this->assertFalse(Alumno::whereNull('deleted_at')->where('id', $alumno->id)->exists());
    }

    public function test_datos_alumno_same_assertSame(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Principe',
            'apellido' => 'Vegeta',
            'email' => 'vegeta@correo.com',
            'edad' => 30,
        ]);

        $alumnoRecuperado = Alumno::find($alumno->id);

        $this->assertSame('Principe', $alumnoRecuperado->nombre);
        $this->assertSame('Vegeta', $alumnoRecuperado->apellido);
        $this->assertSame('vegeta@correo.com', $alumnoRecuperado->email);
        $this->assertSame(30, $alumnoRecuperado->edad); 
    }

    public function test_datos_alumno_equals_assertEquals(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Goku',
            'apellido' => 'Son',
            'email' => 'goku@correo.com',
            'edad' => 28,
        ]);

        $alumnoRecuperado = Alumno::find($alumno->id);

        $this->assertEquals('Goku', $alumnoRecuperado->nombre);
        $this->assertEquals('Son', $alumnoRecuperado->apellido);
        $this->assertEquals('goku@correo.com', $alumnoRecuperado->email);
        $this->assertEquals('28', (string)$alumnoRecuperado->edad);
    }

    public function test_edad_es_numerico_assertIsNumeric(): void
    {
        $alumno = Alumno::create([
            'nombre' => 'Gohan',
            'apellido' => 'Son',
            'email' => 'gohan@correo.com',
            'edad' => 10,
        ]);
    
        $alumnoRecuperado = Alumno::find($alumno->id);
    
        $this->assertIsNumeric($alumnoRecuperado->edad);
    }


}
