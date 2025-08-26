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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->string('logradouro', 255);
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 255)->nullable();
            $table->string('bairro', 255);
            $table->string('cidade', 255);
            $table->char('estado', 2);
            $table->string('cep', 9);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_enderecos');
    }
};
