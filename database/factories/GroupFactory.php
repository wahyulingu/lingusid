<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'type' => $this->faker->randomElement([\App\Models\Menu::class, \App\Models\User::class]),
            'description' => json_encode([
                'url' => $this->faker->url(),
                'icon' => $this->faker->word(),
            ]),
            'parent_id' => null,
        ];
    }

    public function main(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'main',
            ];
        });
    }

    public function sidebar(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'sidebar',
            ];
        });
    }

    public function footer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'footer',
            ];
        });
    }
}
