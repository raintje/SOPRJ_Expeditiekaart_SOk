<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IndexUserTest extends TestCase
{

    /**
     * Tests if the view is correctly displayed.
     *
     * @return void
     */
    public function testIndexUserPageResponse()
    {
        $user = User::first();
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('users.index'));
        $response->assertViewIs('users.index');
        $response->assertStatus(200);
    }

    /** 
     * Asserts if the session contains a list of users. 
     * 
     * @return void
     */
    public function testSessionContainsUsers() 
    {
        $user = User::first();
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('users.index'));
        $response->assertViewHas('users');
    }

}
