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
        return [
            'layer_item_id' => $this->faker->randomElement($layerItems),
            'title' => 'Bestandnaam',
            'type' => $this->faker->randomElement($categories),
            'path' => 'Pad/Naar/Bestand/In/Filesystem',
        ];
    }
}
