<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\MunicipioController;

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/tipos_documento', [TipoDocumentoController::class, 'index']);
    Route::get('/generos', [GeneroController::class, 'index']);
    Route::get('/departamentos', [DepartamentoController::class, 'index']);
    Route::get('/municipios', [MunicipioController::class, 'index']);
});

// Login público
Route::post('/login', [UserController::class, 'login']);

// Grupo protegido con JWT
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/me', [UserController::class, 'me']);
    Route::post('/logout', [UserController::class, 'logout']);

    // CRUD pacientes
    Route::get('/pacientes', [PacienteController::class, 'index']);
    Route::post('/pacientes', [PacienteController::class, 'store']);
    Route::get('/pacientes/{id}', [PacienteController::class, 'show']);
    Route::put('/pacientes/{id}', [PacienteController::class, 'update']);
    Route::delete('/pacientes/{id}', [PacienteController::class, 'delete']);
});

