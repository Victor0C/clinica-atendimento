<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;
use App\Services\Clinicas\ClinicasService;
use App\Services\Clinicas\GetAllClinicasService;
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
            GetAllClinicasServiceInterface::class => GetAllClinicasService::class

        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
