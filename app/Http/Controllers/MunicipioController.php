<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('departamento_id')) {
            $municipios = Municipio::where('departamento_id', $request->departamento_id)->get();
        } else {
            $municipios = Municipio::all();
        }

        return response()->json($municipios);
    }
}
