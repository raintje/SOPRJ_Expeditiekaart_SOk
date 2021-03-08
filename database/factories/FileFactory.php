<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\LayerItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $layerItems = LayerItem::pluck('id')->toArray();
        $categories = ['image', 'video'];
        $testBlurbs = ['testblurb one', 'testblurb two', 'testblurb three', 'testblurb four'];
        return [
            'id' => $this->faker->numberBetween(0, 20),
            'layer_item_id' => $this->faker->randomElement($layerItems),
            'name' => $this->faker->randomElement($testBlurbs),
            'type' => $this->faker->randomElement($categories),
            'path' => $this->faker->randomElement($testBlurbs)
        ];
    }
}
