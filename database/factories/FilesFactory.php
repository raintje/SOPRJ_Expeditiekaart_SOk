<?php

namespace Database\Factories;

use App\Models\files;
use App\Models\LayerItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = files::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $layerItems = LayerItem::pluck('id')->toArray();
        $categories = ['image', 'video'];
        $fileName = "fileName";
        $filePath = "~/Path/To/Item/";
        return [
            'id' => $this->faker->numberBetween(0, 20),
            'name' => $this->$fileName,
            'type' => $this->faker->randomElement($categories),
            'path' => $this->$filePath,
            'layer_item_id' => $this->faker->randomElement($layerItems)
        ];
    }
}
