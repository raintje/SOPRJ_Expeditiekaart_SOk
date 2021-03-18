<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FirstLayerItem;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'familie/sociaal', 'color' => 'blue'],
            ['name' => 'bedrijfskunde', 'color' => 'red'],
            ['name' => 'persoonlijke ontwikkeling', 'color' => 'green'],
        ];

        foreach ($items as $item) {
            Category::create($item);
        }
        $categories = Category::all();

        FirstLayerItem::all()->each(function ($item) use ($categories)
        {
            $item->categories()->saveMany($categories->random(rand(1,2)));
        });
    }
}
