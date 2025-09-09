<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('departamento_id');
            $table->string('nombre');
            $table->timestamps();

            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
