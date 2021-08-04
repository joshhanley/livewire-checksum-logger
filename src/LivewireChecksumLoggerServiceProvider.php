<?php

namespace LivewireChecksumLogger;

use Illuminate\Support\ServiceProvider;

class LivewireChecksumLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/livewire-checksum-logger.php',
            'livewire-checksum-logger'
        );
    }

    public function boot()
    {
        if (! config('livewire-checksum-logger.enable', false)) {
            return;
        }

        LivewireChecksumLogger::logInitialResponse();

        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(LivewireChecksumLoggerMiddleware::class);
    }
}
