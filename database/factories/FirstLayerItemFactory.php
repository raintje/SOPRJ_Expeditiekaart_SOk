<?php

namespace Database\Factories;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class FirstLayerItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FirstLayerItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $layerItems = LayerItem::pluck('id')->toArray();
        $categories = ['familie/sociaal','bedrijfskunde','persoonlijke ontwikkeling']; //TODO define in one place
        return [
            'layer_item_id' => $this->faker->randomElement($layerItems),
            'categorie' => $this->faker->randomElement($categories),
            'x_pos' => $this->faker->numberBetween(0,300),
            'y_pos' =>$this->faker->numberBetween(0,300)
        ];
    }
}
