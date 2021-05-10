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
            $browser->loginAs(User::find(1))
                ->visitRoute('users.index')
            ->assertSee('Gebruikers overzicht');

        });
    }

    /**
     * @group deleteUser
     */
    public function testDeleteUser()
    {
        $this->browse(function (Browser $browser)  {
            $users = User::all()->count();
            $user = User::all()->random()->id;
            $browser->loginAs(User::find(1))
                ->visitRoute('users.index')
                ->assertSee('Gebruikers overzicht')
                ->select('usersTable_length','100')
                ->pause(1000)
                ->click('@delete'.$user)
                ->pause(1000)
                ->press('#deleteUser')
                ->pause(5000)
                ->assertSee('Gebruikersaccount succesvol verwijderd');

            $newUserCount = User::all()->count();
            Assert::assertTrue($newUserCount == $users-1);

        });
    }

    /**
     * @group deleteUser
     */
    public function testDeleteUserWrong()
    {
        $this->browse(function (Browser $browser)  {
            $users = User::all()->count();
            $user = User::all()->random()->id;
            $browser->loginAs(User::find(1))
                ->visitRoute('users.index')
                ->assertSee('Gebruikers overzicht')
                ->select('usersTable_length','100')
                ->pause(1000)
                ->click('@delete'.$user)
                ->pause(1000)
                ->press('#deleteUser')
                ->pause(5000);

            $newUserCount = User::all()->count();
            Assert::assertFalse($newUserCount == $users-2);
        });
    }

}
