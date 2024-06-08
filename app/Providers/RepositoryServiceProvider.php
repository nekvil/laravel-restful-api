<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\NotebookRepositoryInterface;
use App\Repositories\NotebookRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NotebookRepositoryInterface::class, NotebookRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}