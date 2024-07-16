<?php

namespace App\Providers;

use App\Contracts\MetadataStorageInterface;
use App\Contracts\PornstarImporterInterface;
use App\Contracts\PornstarProcessorInterface;
use App\Contracts\StorageServiceInterface;
use App\Services\MetadataStorage;
use App\Services\PornstarImporter;
use App\Services\PornstarProcessor;
use App\Services\StorageService;
use Illuminate\Support\ServiceProvider;

class PornstarImportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PornstarImporterInterface::class, PornstarImporter::class);
        $this->app->bind(MetadataStorageInterface::class, MetadataStorage::class);
        $this->app->bind(PornstarProcessorInterface::class, PornstarProcessor::class);
        $this->app->singleton(StorageServiceInterface::class, StorageService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
