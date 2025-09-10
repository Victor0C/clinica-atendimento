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
        Schema::create('clinicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_fantasia', 255)->nullable(false);
            $table->string('razao_social', 255)->nullable(false)->unique();
            $table->string('cnpj', 18)->nullable(false)->unique();
            $table->string('telefone_fixo', 15)->nullable();
            $table->string('celular', 15)->nullable(false);
            $table->string('email', 255)->nullable(false)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_clinica');
    }
};
