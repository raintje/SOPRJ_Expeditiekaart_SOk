<?php

namespace Database\Factories;

use App\Models\files;
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
        $categories = ['image', 'video'];
        $fileName = "fileName";
        $filePath = "~/Path/To/Item/";
        return [
            'id' => $this->faker->numberBetween(0, 20),
            'name' => $this->$fileName,
            'type' => $this->faker->randomElement($categories),
            'path' => $this->$filePath,
        ];
    }
}
