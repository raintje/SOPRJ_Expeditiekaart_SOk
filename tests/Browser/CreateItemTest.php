<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateItemTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');

    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testPageExists()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/items/create')
                    ->assertSee('Items aanmaken');
        });

    }

    public function testValidationWithoutData()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/items/create')
                ->press('Opslaan')
                ->assertSee('De titel van een item is verplicht.')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });

    }

    public function testBodyValidation()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/items/create')
                ->type('title', 'this is a testTitle')
                ->press('Opslaan')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });

    }

    public function testDuplicateItemCreation()
    {

        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                ->visit('/items/create')
                ->type('title', LayerItem::first()->title)
                ->press('Opslaan')
                ->assertSee('De titel moet uniek zijn.')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });

    }

}
