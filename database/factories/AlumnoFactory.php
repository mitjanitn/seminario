<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/*Modelo del que se orig*/
use App\Models\Alumno;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model=Alumno::class;
    public function definition(): array
    {
        /*Sirve para generar datos aleatorios */
        return [
            'nombre'=>$this->faker->firstName,
            'apellido'=>$this->faker->lastName,
            'email'=>$this->faker->unique->safeEmail,
            'edad'=>$this->faker->numberBetween(18,30)
            /*de 18 a 30 años */
        ];
    }
}
