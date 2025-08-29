<?php

namespace App\Abstractions\Repository;

use App\Abstractions\Traits\Repository\HasModel;
use App\Contracts\Repository\ModelRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class ModelRepository implements ModelRepositoryContract
{
    use HasModel;

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->getModel()->all($columns);
    }

    /**
     * @return TModel|null
     */
    public function find($key, array $columns = ['*'], array $relations = [])
    {
        $model = $this->getModel();

        return ! empty($relations)
            ? $model::with($relations)->find($key, $columns)
            : $model::find($key, $columns);
    }

    /**
     * @return TModel
     */
    public function store(array $attributes)
    {
        return $this->getModel()::create($attributes);
    }

    public function update($key, array $attributes): ?Model
    {
        $model = $this->getModel()::find($key);

        if ($model) {
            $model->update($attributes);

            return $model;
        }

        return null;
    }

    public function delete($key): bool
    {
        return (bool) $this->getModel()->whereKey($key)->delete();
    }

    public function index(
        array $filters = [],
        array $relations = [],
        string $orderBy = 'id',
        string $orderDirection = 'desc'
    ) {
        $builder = $this->getModel()->query();

        // Apply relations
        if (! empty($relations)) {
            $builder->with($relations);
        }

        // Apply filters
        foreach ($filters as $filterKey => $filterValue) {
            if ($filterKey === 'exclude' && is_array($filterValue)) {
                foreach ($filterValue as $excludeKey => $excludeValue) {
                    $builder->where($excludeKey, '!=', $excludeValue);
                }
            } elseif (is_string($filterValue)) {
                foreach (explode('|', $filterKey) as $keyIndex => $keyValue) {
                    if ($keyValue !== '') {
                        if (str_ends_with($keyValue, ':')) {
                            $key = substr($keyValue, 0, -1);
                            $builder->where($key, 'LIKE', $filterValue);
                        } else {
                            $builder->where($keyValue, $filterValue);
                        }
                    }
                }
            } elseif (is_scalar($filterValue)) {
                $builder->where($filterKey, $filterValue);
            } elseif ($filterValue instanceof Model) {
                $builder->whereHas($filterKey, fn ($q) => $q->where(
                    $filterValue->getKeyName(),
                    $filterValue->getKey()
                ));
            }
        }

        // Apply ordering
        return $builder->orderBy($orderBy, $orderDirection);
    }
}
