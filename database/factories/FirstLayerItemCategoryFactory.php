<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\FirstLayerItem;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class FirstLayerItemCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $firstLayerItems = FirstLayerItem::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        return [
            'first_layer_item_id' => $this->faker->randomElement($firstLayerItems),
            'category_id' => $this->faker->randomElement($categories),
        ];
    }
}
