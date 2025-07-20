<?php

namespace App\Repositories;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Throwable;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class Repository
{
    /**
     * @var class-string<Model>|null
     */
    protected $model;

    /**
     * @var string|null
     */
    protected static $namespace;

    /**
     * @var callable|null
     */
    protected static $modelNameResolver;

    /**
     * @var callable|null
     */
    protected static $repositoryNameResolver;

    protected function model(?callable $action = null): mixed
    {
        $resolver = static::$modelNameResolver ?? function (self $repository) {
            $namespacedRepositoryBasename = Str::replaceLast(
                'Repository',
                '',
                Str::replaceFirst(static::namespace(), '', get_class($repository))
            );
            $repositoryBasename = Str::replaceLast('Repository', '', class_basename($repository));
            $appNamespace = static::appNamespace();

            return class_exists($appNamespace.'Models\\'.$namespacedRepositoryBasename)
                ? $appNamespace.'Models\\'.$namespacedRepositoryBasename
                : $appNamespace.$repositoryBasename;
        };

        $modelClass = $this->model ?? $resolver($this);

        return $action ? $action($modelClass) : $modelClass;
    }

    public static function guessModelNamesUsing(callable $modelNameResolver): void
    {
        static::$modelNameResolver = $modelNameResolver;
    }

    public static function useNamespace(string $modelNamespace): void
    {
        static::$namespace = $modelNamespace;
    }

    public static function new(): static
    {
        return new static;
    }

    public static function repositoryForModel(string $modelName): static
    {
        return static::resolveRepositoryName($modelName)::new();
    }

    public static function resolveRepositoryName(string $modelName): string
    {
        $resolver = static::$repositoryNameResolver ?? function (string $modelName) {
            $appNamespace = static::appNamespace();
            $modelName = Str::startsWith($modelName, $appNamespace.'Models\\')
                ? Str::after($modelName, $appNamespace.'Models\\')
                : Str::after($modelName, $appNamespace);

            return static::namespace().$modelName.'Repository';
        };

        return $resolver($modelName);
    }

    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                ->make(Application::class)
                ->getNamespace();
        } catch (Throwable) {
            return 'App\\';
        }
    }

    protected static function namespace(): string
    {
        return static::$namespace ?? static::appNamespace().'Repositories\\';
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model()::all($columns);
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->all($columns);
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
