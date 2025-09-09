<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    // Listar todos los departamentos
    public function index()
    {
        return response()->json(Departamento::all());
    }
}
