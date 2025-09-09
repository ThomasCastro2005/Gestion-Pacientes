<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;

class DepartamentosSeeder extends Seeder
{
    public function run(): void
    {
        $departamentos = ['Antioquia','Cundinamarca','Valle del Cauca','Santander','Bolívar'];
        foreach ($departamentos as $nombre) {
            Departamento::create(['nombre' => $nombre]);
        }
    }
}
