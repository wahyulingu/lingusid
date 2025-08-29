<?php

namespace App\Abstractions\Traits\Repository;

use App\Contracts\Repository\RepositoryContract;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

trait HasModel
{
    final public static function getNamespace(): string
    {
        return App::getNamespace().'Repositories\\';
    }

    final public function getModel(?Closure $callable = null): Model
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

    final public static function resolve(string $modelName): RepositoryContract
    {
        $appNamespace = App::getNamespace();

        $modelName = Str::startsWith($modelName, $appNamespace.'Models\\')
            ? Str::after($modelName, $appNamespace.'Models\\')
            : Str::after($modelName, $appNamespace);

        return app(self::getNamespace().$modelName.'Repository');
    }
}
