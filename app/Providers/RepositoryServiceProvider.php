<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\EmpresaRepositoryInterface;
use App\Infrastructure\Persistence\EloquentEmpresaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EmpresaRepositoryInterface::class, EloquentEmpresaRepository::class);
    }
}
