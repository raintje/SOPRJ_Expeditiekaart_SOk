<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

class AuthorizePagesTest extends DuskTestCase
{
    /**
     * @group AuthorizeAdminPages
     * @group AuthorizeAllPages
     */
    public function testAdminAuthAllPages()
    {
        $this->browse(function (Browser $browser) {
            $routes = [ 
                route('users.edit', ['user' => User::first()]),
                route('users.show', ['user' => user::first()]),
                route('users.index'),
                route('dashboard'),
                route('show.item', ['id' => LayerItem::first()]),
                route('edit.item', ['id' => LayerItem::first()]),
                route('create.item'),
                route('roles.create'),
                route('roles.edit', ['role' => Role::first()]),
                route('roles.show', ['role' => role::first()]),
                route('roles.index'),
                route('edit.item.location')
            ];

            $browser->loginAs(User::role('super admin')->first());

            foreach($routes as $route){
                $browser->visit($route)->assertUrlIs($route);
            }

        });
    }

    /**
     * @group AuthorizeAdminPages
     * @group AuthorizeAllPages
     */
    public function testAdminOtherAuth()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::role('super admin')->first())
                    ->visit(route('show.item', ['id' => LayerItem::first()]))
                    ->assertPresent('@edit-button')
                    ->assertPresent('@delete-button');
        });
    }


    /**
     * @group AuthorizeDefaultUserPages
     * @group AuthorizeAllPages
     */
    public function testDefaultUserNotAuthorizePages()
    {
        $this->browse(function (Browser $browser) {
            $routes = [ 
                route('users.edit', ['user' => User::first()]),
                route('users.show', ['user' => user::first()]),
                route('users.index'),
                route('dashboard'),
                route('edit.item', ['id' => LayerItem::first()]),
                route('create.item'),
                route('roles.create'),
                route('roles.edit', ['role' => Role::first()]),
                route('roles.show', ['role' => role::first()]),
                route('roles.index'),
                route('edit.item.location')
            ];

            $browser->logout();

            foreach($routes as $route){
                $browser->visit($route)->assertUrlIs(route('login'));
            }
        });
    }

    /**
     * @group AuthorizeDefaultUserPages
     * @group AuthorizeAllPages
     */
    public function testDefaultUserAuthorizePages()
    {
        $this->browse(function (Browser $browser) {
            $routes = [ 
                route('show.item', ['id' => LayerItem::first()]),
                route('login'),
                route('register')
            ];

            $browser->logout();

            foreach($routes as $route){
                $browser->visit($route)->assertUrlIs($route);
            }

        });
    }

    /**
     * @group AuthorizeDefaultUserPages
     * @group AuthorizeAllPages
     */
    public function testDefaultUserOtherAuthPages(){
        $this->browse(function (Browser $browser) {
            $browser->logout()
                    ->visit(route('show.item', ['id' => LayerItem::first()]))
                    ->assertNotPresent('@edit-button')
                    ->assertNotPresent('@delete-button');
    
        });
    }
}
