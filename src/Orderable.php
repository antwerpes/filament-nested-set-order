<?php declare(strict_types=1);

namespace Antwerpes\FilamentNestedSetOrder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

trait Orderable
{
    protected static function bootOrderable(): void
    {
        if (config('filament-nested-set-order.cache_enabled') === false) {
            return;
        }

        static::created(function ($model): void {
            $model->clearOrderableCache();
        });

        static::updated(function ($model): void {
            $model->clearOrderableCache();
        });

        static::deleted(function ($model): void {
            $model->clearOrderableCache();
        });
    }

    public function moveOrderUp(): void
    {
        $prevItem = $this->getPrevSibling();

        if ($prevItem !== null) {
            $this->insertBeforeNode($prevItem);
        }
    }

    public function moveOrderDown(): void
    {
        $nextItem = $this->getNextSibling();

        if ($nextItem !== null) {
            $this->insertAfterNode($nextItem);
        }
    }

    public function buildSortQuery(): Builder
    {
        /** @var Builder $query */
        $query = static::query()->where($this->getParentIdName(), $this->getParentId());

        if ($this->getScopeAttributes() === null) {
            return $query;
        }

        foreach ($this->getScopeAttributes() as $attributeName) {
            if ($this->{$attributeName} !== null) {
                $query->where($attributeName, $this->{$attributeName});
            }
        }

        return $query;
    }

    public function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy($this->getLftName(), $direction);
    }

    public function getOrderableCachePrefix(): string
    {
        return 'filament-nested-set-order'.md5(static::class.'-'.(int) $this->{$this->getParentIdName()});
    }

    /**
     * Clear the cache corresponding to the model.
     */
    public function clearOrderableCache(): void
    {
        Cache::forget($this->getOrderableCachePrefix().'.first');
        Cache::forget($this->getOrderableCachePrefix().'.last');
    }
}
