<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('encaminhamentos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('clinica_id_destino');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('procedimento_id');

            $table->timestamps();

            $table->foreign('clinica_id_destino')
                ->references('id')
                ->on('clinicas');

            $table->foreign('paciente_id')
                ->references('id')
                ->on('pacientes');

            $table->foreign('procedimento_id')
                ->references('id')
                ->on('procedimentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encaminhamentos');
    }
};
