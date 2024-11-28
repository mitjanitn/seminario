<?php

namespace Tests\Unit;

//no usar, no funciona
//use PHPUnit\Framework\TestCase;

//colocar todo esto
use App\Models\Alumno;
use App\Http\Controllers\AlumnoController;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AlumnoControllerUnitTest extends TestCase
{
    //Prueba que al no ingresar datos se genera una excepcion o falla
    //sale correcta porque intencionalmente tiene que ocurrir el error
    public function test_probar_validacion_falla_para_crear_Alumnos()
    {
        //variable para el cotnrolador
        //aqui se crea la instancia del controller
        $controller = new AlumnoController;
        
        //crear el request
        //post en create, put en update

        // arrey asociativo de los elementos del Alumno::create
        $request = Request::create('/alumno', 'POST', [
            'name' => '', //campo en blanco
            'apellido' => 'Castro',
            'email' => '',
            'edad' => '29'
        ]);
        //esto espera un error, si se quita esta linea va a tirar error el test
        $this->expectException(ValidationException::class);
        // Se espera que falle la validación
        $controller->store($request);

    }

    /* Prueba de qye al ingresar los datos de forma correcta se ejecuta
    la captura de los datos correctamente */
    public function test_probar_validacion_correcta_para_crear_Alumnos()
    {
        $controller = new AlumnoController;
        //es necesario que todas tenga validaciones en el controller, sino tira error (minimo requerido)
        $request = Request::create('/alumno', 'POST', [
            'name' => 'Kevin',  //se ingresan datos para comprobar la validacion requiere
            'apellido' => 'Calix',
            'email' => 'kcalix@unicah.edu',
            'edad' => '20'
        ]);
        //si no se genera la excepción o fallo, la validacion sera correcta
        $response = $controller->store($request);
        //Por si no funciona la linea de arriba poner: $response=$controller->store($request);
        $this->assertTrue($response->isRedirect(route('alumnos.index')));
    }

    public function test_probar_validacion_falla_para_correo_Alumnos()
    {
        $controller = new AlumnoController;
        $request = Request::create('/alumno', 'POST', [
            'name' => 'Adam', 
            'apellido' => 'Castro',
            'email' => '',
            'edad' => '29'
        ]);
        $this->expectException(ValidationException::class);
        $controller->store($request);
    }
}
