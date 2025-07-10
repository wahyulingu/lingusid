<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'url' => $this->faker->url(),
            'icon' => $this->faker->word(),
            'order' => $this->faker->numberBetween(0, 100),
            'parent_id' => null,

        ];
    }

    public function withParent(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Menu::factory(),
            ];
        });
    }
}
