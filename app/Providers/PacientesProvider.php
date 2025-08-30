<?php

namespace App\Providers;

use App\CreatePacienteServiceInterface;
use App\DeletePacienteServiceInterface;
use App\GetPacienteServiceInterface;
use App\Helpers\AppHelper;
use App\PacienteServiceInterface;
use App\Services\Pacientes\CreatePacienteService;
use App\Services\Pacientes\DeletePacienteService;
use App\Services\Pacientes\GetPacienteService;
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
            GetPacienteServiceInterface::class => GetPacienteService::class,
            DeletePacienteServiceInterface::class => DeletePacienteService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
