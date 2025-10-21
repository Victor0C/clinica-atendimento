<?php

namespace App\Providers;

use App\Helpers\AppHelper;
use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\Services\Procedimentos\ProcedimentosService;
use Illuminate\Support\ServiceProvider;

class ProcedimentosProvider extends ServiceProvider
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
            ProcedimentosServiceInterface::class => ProcedimentosService::class,
        ];

        AppHelper::bindMultiple($this->app, $bindings);
    }
}
