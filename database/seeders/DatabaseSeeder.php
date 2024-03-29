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
            'email' => 'admin@expeditiekaart.nl',
            'email_verified_at' => now(),
            'password' => Hash::make('!expAdmin302'), // password = !expAdmin302
        ]);
        User::factory(30)->create();
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(LayerItemSeeder::class);
        FirstLayerItem::factory(LayerItem::where('level', 1)->count())->create();
        $this->call(LayerItemLayerItemSeeder::class);
        File::factory(10)->create();

    }
}
