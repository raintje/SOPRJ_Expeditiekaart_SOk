<?php

namespace Database\Seeders;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\User;
use Database\Factories\FirstLayerItemCategoryFactory;
use Illuminate\Database\Seeder;
use \App\Models\File;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        LayerItem::factory(10)->create();
        FirstLayerItem::factory(10)->create();
        $this->call(CategoriesTableSeeder::class);
        $this->call(LayerItemLayerItemSeeder::class);
        File::factory(10)->create();
    }
}
