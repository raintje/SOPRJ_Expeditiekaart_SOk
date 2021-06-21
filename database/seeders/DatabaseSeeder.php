<?php

namespace Database\Seeders;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\User;
use Database\Factories\FirstLayerItemCategoryFactory;
use Illuminate\Database\Seeder;
use \App\Models\File;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Admin123!'), // password = Admin123!
        ]);
        User::factory(20)->create();
        $this->call(LayerItemSeeder::class);
        FirstLayerItem::factory(LayerItem::all()->count())->create();
        $this->call(CategoriesTableSeeder::class);
        $this->call(LayerItemLayerItemSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        File::factory(10)->create();

    }
}
