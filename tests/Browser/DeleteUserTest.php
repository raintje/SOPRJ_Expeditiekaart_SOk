<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert;
use Tests\DuskTestCase;

class DeleteUserTest extends DuskTestCase
{
    /**
     * @group deleteUser
     */
    public function testSeeOverviewNotLoggedIn()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('users.index')
                ->assertPathIs('/login');

        });
    }

    /**
     * @group deleteUser
     */
    public function testSeeOverview()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->assertAuthenticated()
                    ->visitRoute('users.index')
                    ->assertSee('Gebruikers overzicht')
                    ->visitRoute('users.index')
                    ->assertSee('Gebruikers overzicht');
        });
    }

    /**
     * @group deleteUser
     */
    // public function testDeleteUser()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $users = User::all()->count();
    //         $user = User::all()->random()->id;
    //         $browser->loginAs(User::first())
    //                 ->assertAuthenticated()
    //                 ->visitRoute('users.index')
    //                 ->assertSee('Gebruikers overzicht')
    //                 ->pause(500)
    //                 ->select('usersTable_length', 100)
    //                 ->assertSelected('usersTable_length', 100)
    //                 ->pause(500)
    //                 ->click('@delete' . $user)
    //                 ->pause(500)
    //                 ->press('#deleteUser')
    //                 ->pause(500)
    //                 ->assertSee('Gebruikersaccount succesvol verwijderd');

    //         $newUserCount = User::all()->count();
    //         Assert::assertTrue($newUserCount == $users - 1);
    //     });
    // }

    /**
     * @group deleteUser
     */
    // public function testDeleteUserWrong()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $users = User::all()->count();
    //         $user = User::all()->random()->id;
    //         $browser->loginAs(User::first())
    //                 ->assertAuthenticated()
    //                 ->visitRoute('users.index')
    //                 ->assertSee('Gebruikers overzicht')
    //                 ->select('usersTable_length', 100)
    //                 ->pause(500)
    //                 ->click('@delete' . $user)
    //                 ->pause(500)
    //                 ->press('#deleteUser')
    //                 ->pause(500);

    //         $newUserCount = User::all()->count();
    //         Assert::assertFalse($newUserCount == $users - 2);
    //     });
    // }

}
