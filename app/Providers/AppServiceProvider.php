<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EmpresaRepositoryInterface;
use App\Repositories\EmpresaRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmpresaRepositoryInterface::class, EmpresaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
