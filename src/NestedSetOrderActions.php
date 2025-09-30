<?php declare(strict_types=1);

namespace Antwerpes\FilamentNestedSetOrder;

use Filament\Actions\Action;
use Illuminate\Support\Facades\Cache;

class NestedSetOrderActions
{
    public static function make(): array
    {
        return [
            Action::make('up')
                ->icon('heroicon-s-arrow-up-circle')
                ->iconButton()
                ->action(fn ($record) => $record->moveOrderUp())
                ->visible(function ($record) {
                    $first = config('filament-nested-set-order.cache_enabled')
                        ? Cache::rememberForever(
                            $record->getOrderableCachePrefix().'-first',
                            fn () => $record->buildSortQuery()->ordered()->first(),
                        )
                        : $record->buildSortQuery()->ordered()->first();

                    return $record->id !== $first?->id;
                }),
            Action::make('down')
                ->icon('heroicon-s-arrow-down-circle')
                ->iconButton()
                ->action(fn ($record) => $record->moveOrderDown())
                ->visible(function ($record) {
                    $last = config('filament-nested-set-order.cache_enabled')
                        ? Cache::rememberForever(
                            $record->getOrderableCachePrefix().'-last',
                            fn () => $record->buildSortQuery()->ordered('desc')->first(),
                        )
                        : $record->buildSortQuery()->ordered('desc')->first();

                    return $record->id !== $last?->id;
                }),
        ];
    }
}
