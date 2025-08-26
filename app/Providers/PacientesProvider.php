<?php

namespace App\Providers;

use App\CreatePacienteServiceInterface;
use App\Helpers\AppHelper;
use App\PacienteServiceInterface;
use App\Services\Pacientes\CreatePacienteService;
use App\Services\Pacientes\PacienteService;
use Illuminate\Support\ServiceProvider;

class PacientesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $bindings = [
            PacienteServiceInterface::class => PacienteService::class,
            CreatePacienteServiceInterface::class => CreatePacienteService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
