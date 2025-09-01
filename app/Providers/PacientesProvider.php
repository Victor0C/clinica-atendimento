<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Interfaces\Paciente\DeletePacienteServiceInterface;
use App\Interfaces\Paciente\GetAllPacienteServiceInterface;
use App\Interfaces\Paciente\GetPacienteServiceInterface;
use App\Interfaces\Paciente\PacienteServiceInterface;
use App\Services\Pacientes\CreatePacienteService;
use App\Services\Pacientes\DeletePacienteService;
use App\Services\Pacientes\GetAllPacienteService;
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
            GetAllPacienteServiceInterface::class => GetAllPacienteService::class,
            DeletePacienteServiceInterface::class => DeletePacienteService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
