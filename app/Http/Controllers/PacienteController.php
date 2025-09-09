<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class PacienteController extends Controller
{
    // Mostrar todos los pacientes
    public function index()
    {
        try {
            $pacientes = Paciente::with(['tipoDocumento','genero','departamento','municipio'])->get();
            return response()->json($pacientes);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener pacientes',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // Crear un paciente
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_documento_id' => 'required|exists:tipos_documento,id',
            'numero_documento' => 'required|unique:pacientes,numero_documento',
            'nombre' => 'required|string|max:255',
            'genero_id' => 'required|exists:generos,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'correo' => 'required|email|unique:pacientes,correo',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validación fallida', 'mensaje' => $validator->errors()], 422);
        }

        try {
            $paciente = Paciente::create($request->all());
            return response()->json($paciente, 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al crear paciente',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        try {
            $paciente = Paciente::with(['tipoDocumento','genero','departamento','municipio'])->findOrFail($id);
            return response()->json($paciente);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener paciente',
                'mensaje' => $e->getMessage()
            ], 404);
        }
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'tipo_documento_id' => 'sometimes|exists:tipos_documento,id',
                'numero_documento' => 'sometimes|unique:pacientes,numero_documento,' . $id,
                'nombre' => 'sometimes|string|max:255',
                'genero_id' => 'sometimes|exists:generos,id',
                'departamento_id' => 'sometimes|exists:departamentos,id',
                'municipio_id' => 'sometimes|exists:municipios,id',
                'correo' => 'sometimes|email|unique:pacientes,correo,' . $id,
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Validación fallida', 'mensaje' => $validator->errors()], 422);
            }

            $paciente->update($request->all());

            return response()->json($paciente);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar paciente',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }

    // Eliminar paciente
    public function delete($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            $paciente->delete();

            return response()->json(['mensaje' => 'Paciente eliminado correctamente']);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar paciente',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
}
