<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GenerosSeeder extends Seeder
{
    public function run(): void
    {
        $generos = ['Masculino','Femenino'];
        foreach($generos as $g) {
            Genero::create(['nombre'=>$g]);
        }
    }
}
