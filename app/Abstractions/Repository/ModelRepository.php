<?php

namespace App\Abstractions\Repository;

use App\Contracts\Repository\ModelRepositoryContract;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
abstract class ModelRepository implements ModelRepositoryContract
{
    final public static function getNamespace(): string
    {
        return App::getNamespace().'Repositories\\';
    }

    final public function query(?Closure $callable = null): Builder
    {
        $repositoryName = Str::replaceFirst(self::getNamespace(), '', get_class($this));
        $modelName = Str::replaceLast('Repository', '', $repositoryName);

        if (! class_exists($modelClass = App::getNamespace().'Models\\'.$modelName)) {
            $modelClass = App::getNamespace().$modelName;
        }

        $builder = app($modelClass)->newQuery();

        if (! is_null($callable)) {
            $callable($builder);
        }

        return $builder;
    }

    final public static function resolve(string $modelName): static
    {
        $appNamespace = App::getNamespace();

        $modelName = Str::startsWith($modelName, $appNamespace.'Models\\')
            ? Str::after($modelName, $appNamespace.'Models\\')
            : Str::after($modelName, $appNamespace);

        return app(self::getNamespace().$modelName.'Repository');
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function find(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    public function findOrFail(int|string $id, array $columns = ['*']): Model
    {
        return $this->query()->findOrFail($id, $columns);
    }

    public function store(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function update(int|string $id, array $data): bool
    {
        return $this->findOrFail($id)->update($data);
    }

    public function delete(int|string $id): bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage, $columns);
    }

    public function findBySlug(string $slug, array $columns = ['*']): ?Model
    {
        return $this->query()->where('slug', $slug)->first($columns);
    }
}
