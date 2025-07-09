<?php

namespace App\Actions;

abstract class Action
{
    abstract public function handle(...$args);
}