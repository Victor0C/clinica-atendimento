<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use App\Interfaces\Especialidades\EspecialidadeServiceInterface;
use App\Services\Especialidades\EspecialidadeService;
use Illuminate\Support\ServiceProvider;

class EspecialidadesProvider extends ServiceProvider
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
            EspecialidadeServiceInterface::class => EspecialidadeService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
