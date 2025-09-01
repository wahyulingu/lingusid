<?php

namespace App\Contracts\Repository;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ModelRepositoryContract extends RepositoryContract
{
    public static function resolve(string $modelName): static;

    public function query(?Closure $callable = null): Builder;

    public function all(array $columns = ['*']): Collection;

    public function find(int|string $id, array $columns = ['*']): ?Model;

    public function findOrFail(int|string $id, array $columns = ['*']): Model;

    public function store(array $data): Model;

    public function update(int|string $id, array $data): bool;

    public function delete(int|string $id): bool;

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function findBySlug(string $slug, array $columns = ['*']): ?Model;
}
