<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    // Listar todos los géneros
    public function index()
    {
        return response()->json(Genero::all());
    }
}
