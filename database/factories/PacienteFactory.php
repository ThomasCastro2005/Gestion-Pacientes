<?php

namespace Database\Factories;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Departamento;
use App\Models\Municipio;

class PacienteFactory extends Factory
{
    protected $model = Paciente::class;

    public function definition()
    {
        $departamento = Departamento::factory()->create();
        return [
            'nombre' => $this->faker->name,
            'correo' => $this->faker->unique()->safeEmail,
            'tipo_documento_id' => TipoDocumento::factory(),
            'numero_documento' => $this->faker->numerify('#########'),
            'genero_id' => Genero::factory(),
            'departamento_id' => $departamento->id,
            'municipio_id' => Municipio::factory()->create(['departamento_id' => $departamento->id])->id,
        ];
    }
}
