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
        // Tabela de pacientes
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->date('data_nascimento');
            $table->string('cpf', 14)->unique();
            $table->string('rg', 20)->unique();
            $table->enum('sexo', ['M', 'F', 'O']);
            $table->string('telefone_fixo', 15)->nullable();
            $table->string('celular', 15);
            $table->string('email', 255)->unique();
            $table->string('convenio', 50)->nullable();
            $table->string('numero_carteirinha', 30)->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos_pacientes');
        Schema::dropIfExists('pacientes');
    }
};
