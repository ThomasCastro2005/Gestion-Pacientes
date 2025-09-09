<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Paciente;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Departamento;
use App\Models\Municipio;

class PacienteTest extends TestCase
{
    use RefreshDatabase; // Para resetear la BD en cada prueba

    /** @test */
    public function puede_crear_un_paciente()
    {
        $tipoDocumento = TipoDocumento::factory()->create();
        $genero = Genero::factory()->create();
        $departamento = Departamento::factory()->create();
        $municipio = Municipio::factory()->create(['departamento_id' => $departamento->id]);

        $paciente = Paciente::create([
            'nombre' => 'Thomas Castro',
            'correo' => 'thomas@example.com',
            'tipo_documento_id' => $tipoDocumento->id,
            'numero_documento' => '123456789',
            'genero_id' => $genero->id,
            'departamento_id' => $departamento->id,
            'municipio_id' => $municipio->id,
        ]);

        $this->assertDatabaseHas('pacientes', [
            'nombre' => 'Thomas Castro',
            'correo' => 'thomas@example.com'
        ]);
    }

    /** @test */
    public function puede_actualizar_un_paciente()
    {
        $paciente = Paciente::factory()->create(['nombre' => 'Old Name']);
        $paciente->update(['nombre' => 'New Name']);

        $this->assertDatabaseHas('pacientes', ['nombre' => 'New Name']);
    }

    /** @test */
    public function puede_eliminar_un_paciente()
    {
        $paciente = Paciente::factory()->create();
        $paciente->delete();

        $this->assertDatabaseMissing('pacientes', [
            'id' => $paciente->id
        ]);
    }
}
