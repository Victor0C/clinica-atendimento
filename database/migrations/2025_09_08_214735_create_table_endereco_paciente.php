<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('enderecos', function (Blueprint $table) {
            if (Schema::hasColumn('enderecos', 'paciente_id')) {
                $table->dropForeign(['paciente_id']);
                $table->dropColumn('paciente_id');
            }
        });

        Schema::create('endereco_paciente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('endereco_id');
            $table->unsignedBigInteger('paciente_id');
            $table->timestamps();

            $table->foreign('endereco_id')->references('id')->on('enderecos')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');

            $table->unique(['endereco_id', 'paciente_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('endereco_paciente');

        Schema::table('enderecos', function (Blueprint $table) {
            $table->unsignedBigInteger('paciente_id')->nullable();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        });
    }
};
