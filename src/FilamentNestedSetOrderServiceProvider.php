<?php declare(strict_types=1);

namespace Antwerpes\FilamentNestedSetOrder;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentNestedSetOrderServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-nested-set-order')
            ->hasConfigFile();
    }
}
