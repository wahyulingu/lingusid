<?php

namespace App\Abstractions\Repository;

use App\Contracts\Repository\ModelRepositoryContract;
use App\Contracts\Repository\RepositoryContract;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class ModelRepository implements ModelRepositoryContract, RepositoryContract
{
    final public function getNamespace(): string
    {
        return App::getNamespace().'Repositories\\';
    }

    protected function model(?Closure $callable = null): Model
    {
        $repositoryName = Str::replaceFirst(self::getNamespace(), '', get_class($this));
        $modelName = Str::replaceLast('Repository', '', $repositoryName);

        if (! class_exists($modelClass = App::getNamespace().'Models\\'.$modelName)) {
            $modelClass = App::getNamespace().$modelName;
        }

        $modelInstance = app($modelClass);

        if (! is_null($callable)) {
            $callable($modelInstance);
        }

        return $modelInstance;

    }

    public static function resolve(string $modelName): static
    {
        $appNamespace = App::getNamespace();

        $modelName = Str::startsWith($modelName, $appNamespace.'Models\\')
            ? Str::after($modelName, $appNamespace.'Models\\')
            : Str::after($modelName, $appNamespace);

        return app(self::getNamespace().$modelName.'Repository');
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->model()->all($columns);
    }

    /**
     * @return TModel|null
     */
    public function find($key, array $columns = ['*'], array $relations = [])
    {
        $model = $this->model();

        return ! empty($relations)
            ? $model::with($relations)->find($key, $columns)
            : $model::find($key, $columns);
    }

    /**
     * @return TModel
     */
    public function store(array $attributes)
    {
        return $this->model()::create($attributes);
    }

    public function update($key, array $attributes): ?Model
    {
        $model = $this->model()::find($key);

        if ($model) {
            $model->update($attributes);

            return $model;
        }

        return null;
    }

    public function delete($key): bool
    {
        return (bool) $this->model()::whereKey($key)->delete();
    }

    public function index(
        array $filters = [],
        array $relations = [],
        string $orderBy = 'id',
        string $orderDirection = 'desc'
    ) {
        $builder = $this->model(fn ($model) => $model::query());

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
