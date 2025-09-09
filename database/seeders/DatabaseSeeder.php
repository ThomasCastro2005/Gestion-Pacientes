<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamamos a cada seeder en el orden necesario
        $this->call([
            UsersSeeder::class,
            DepartamentosSeeder::class,
            MunicipiosSeeder::class,
            GenerosSeeder::class,
            TiposDocumentoSeeder::class,
            UsersSeeder::class,
            PacientesSeeder::class,
        ]);
    }
}
