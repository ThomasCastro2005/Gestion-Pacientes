<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipio;

class MunicipiosSeeder extends Seeder
{
    public function run(): void
    {
        $municipios = [
            ['departamento_id'=>1,'nombre'=>'Medellín'],
            ['departamento_id'=>1,'nombre'=>'Envigado'],
            ['departamento_id'=>2,'nombre'=>'Bogotá'],
            ['departamento_id'=>2,'nombre'=>'Soacha'],
            ['departamento_id'=>3,'nombre'=>'Cali'],
            ['departamento_id'=>3,'nombre'=>'Palmira'],
            ['departamento_id'=>4,'nombre'=>'Bucaramanga'],
            ['departamento_id'=>4,'nombre'=>'Floridablanca'],
            ['departamento_id'=>5,'nombre'=>'Cartagena'],
            ['departamento_id'=>5,'nombre'=>'Magangué'],
        ];

        foreach ($municipios as $mun) {
            Municipio::create($mun);
        }
    }
}
