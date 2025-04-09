<?php declare(strict_types=1);

namespace Antwerpes\FilamentNestedSetOrder;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentNestedSetOrderServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-nested-set-order')
            ->hasConfigFile();
    }
}
