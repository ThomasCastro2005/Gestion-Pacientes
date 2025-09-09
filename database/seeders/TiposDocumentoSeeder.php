<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TiposDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Cédula de Ciudadanía','Tarjeta de Identidad'];
        foreach($tipos as $t) {
            TipoDocumento::create(['nombre'=>$t]);
        }
    }
}
