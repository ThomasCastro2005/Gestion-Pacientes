<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacientesSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = [
            [
                'tipo_documento_id'=>1,
                'numero_documento'=>'12345678',
                'nombre'=>'Valentina Buenhombre',
                'genero_id'=>2,
                'departamento_id'=>1,
                'municipio_id'=>1,
                'correo'=>'Valentina@pruebatecnica.com'
            ],
            [
                'tipo_documento_id'=>2,
                'numero_documento'=>'87654321',
                'nombre'=>'Juan Pérez',
                'genero_id'=>1,
                'departamento_id'=>2,
                'municipio_id'=>3,
                'correo'=>'juan@pruebatecnica.com'
            ],
            [
                'tipo_documento_id'=>1,
                'numero_documento'=>'11223344',
                'nombre'=>'Ana Martínez',
                'genero_id'=>2,
                'departamento_id'=>3,
                'municipio_id'=>5,
                'correo'=>'ana@pruebatecnica.com'
            ],
            [
                'tipo_documento_id'=>2,
                'numero_documento'=>'44332211',
                'nombre'=>'Carlos Ramírez',
                'genero_id'=>1,
                'departamento_id'=>4,
                'municipio_id'=>7,
                'correo'=>'carlos@pruebatecnica.com'
            ],
            [
                'tipo_documento_id'=>1,
                'numero_documento'=>'55667788',
                'nombre'=>'María López',
                'genero_id'=>2,
                'departamento_id'=>5,
                'municipio_id'=>9,
                'correo'=>'maria@pruebatecnica.com'
            ],
        ];

        foreach($pacientes as $p) {
            // Evita duplicados por numero_documento o correo
            Paciente::updateOrCreate(
                ['numero_documento' => $p['numero_documento']],
                $p
            );
        }
    }
}
