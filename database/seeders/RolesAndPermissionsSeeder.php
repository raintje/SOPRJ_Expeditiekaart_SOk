<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        
        Role::create(['name' => 'agrarische notarissen']);
        Role::create(['name' => 'testamenten specialist']);
        Role::create(['name' => 'fiscale specialist']);
        Role::create(['name' => 'gebruiker']);

        $admin = User::find(1);

        $admin->assignRole($adminRole);

        foreach(User::where('id', '!=', 1)->get() as $user){
            $user->assignRole('gebruiker');
        }
        
    }
}
