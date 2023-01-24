# Filament Nested Set Order

[![Latest Version on Packagist](https://img.shields.io/packagist/v/antwerpes/filament-nested-set-order.svg?style=flat-square)](https://packagist.org/packages/antwerpes/filament-nested-set-order)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/antwerpes/filament-nested-set-order/lint?label=code%20style)](https://github.com/antwerpes/filament-nested-set-order/actions?query=workflow%3Alint+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/antwerpes/filament-nested-set-order.svg?style=flat-square)](https://packagist.org/packages/antwerpes/filament-nested-set-order)

Filament actions for ordering resources that use [kalnoy/nestedset](https://github.com/lazychaser/laravel-nestedset).

## Installation

```bash
composer require antwerpes/filament-nested-set-order
```

## Usage
1. Ensure your models use the `Kalnoy\Nestedset\NodeTrait` and `Antwerpes\FilamentNestedSetOrder\Orderable` traits.

```php
class Category extends Model
{
    use NodeTrait;
    use Orderable;
}
```

2. Add the actions to your filament resource and specify the query order:

```php
use Antwerpes\FilamentNestedSetOrder\NestedSetOrderActions;

class CategoryResource extends Resource
{
    public static function table(Table $table): Table
    {
        return $table->prependActions(NestedSetOrderActions::make());
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withDepth()->defaultOrder();
    }
}
```

## Caching
To improve performance you may enable caching:

1. Publish the config file:

```bash
php artisan vendor:publish --tag="filament-nested-set-order-config"
```

2. Enable caching:

```php
return [
    'cache_enabled' => true,
];
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are welcome! Leave an issue on GitHub, or create a Pull Request.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
