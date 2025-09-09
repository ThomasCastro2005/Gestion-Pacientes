<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_documento_id');
            $table->string('numero_documento')->unique();
            $table->string('nombre');
            $table->unsignedBigInteger('genero_id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('municipio_id');
            $table->string('correo')->unique();
            $table->timestamps();

            $table->foreign('tipo_documento_id')->references('id')->on('tipos_documento')->onDelete('cascade');
            $table->foreign('genero_id')->references('id')->on('generos')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
