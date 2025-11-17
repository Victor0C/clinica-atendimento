<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Interfaces\Clinicas\CreateClinicaServiceInterface;
use App\Interfaces\Clinicas\DeleteClinicaServiceInterface;
use App\Interfaces\Clinicas\EditClinicaServiceInterface;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;
use App\Interfaces\Clinicas\GetClinicaServiceInterface;
use App\Services\Clinicas\ClinicasService;
use App\Services\Clinicas\CreateClinicaService;
use App\Services\Clinicas\DeleteClinicaService;
use App\Services\Clinicas\EditClinicaService;
use App\Services\Clinicas\GetAllClinicasService;
use App\Services\Clinicas\GetClinicaService;
use Illuminate\Support\ServiceProvider;

class ClinicasProvider extends ServiceProvider
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
            ClinicasServiceInterface::class => ClinicasService::class,
            GetAllClinicasServiceInterface::class => GetAllClinicasService::class,
            GetClinicaServiceInterface::class => GetClinicaService::class,
            CreateClinicaServiceInterface::class => CreateClinicaService::class,
            EditClinicaServiceInterface::class => EditClinicaService::class,
            DeleteClinicaServiceInterface::class => DeleteClinicaService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
