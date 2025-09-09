<?php

namespace Database\Factories;

use App\Models\Municipio;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Departamento;

class MunicipioFactory extends Factory
{
    protected $model = Municipio::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->city,
            'departamento_id' => Departamento::factory(), // Asocia automáticamente un departamento
        ];
    }
}
