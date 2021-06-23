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
        User::factory(30)->create();
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(LayerItemSeeder::class);
        LayerItem::factory(10)->create();
        FirstLayerItem::factory(LayerItem::where('level', 1)->count())->create();
        File::factory(10)->create();
    }
}
