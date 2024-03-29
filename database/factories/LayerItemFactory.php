<?php

namespace Database\Factories;

use App\Models\LayerItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class LayerItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LayerItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence,
            'body' => $this->faker->text,
            'level' => $this->faker->numberBetween(2,4)
        ];
    }
}
