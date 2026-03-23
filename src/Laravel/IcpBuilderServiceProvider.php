<?php

declare(strict_types=1);

namespace URLCV\IcpBuilder\Laravel;

use Illuminate\Support\ServiceProvider;

class IcpBuilderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'icp-builder');
    }
}
