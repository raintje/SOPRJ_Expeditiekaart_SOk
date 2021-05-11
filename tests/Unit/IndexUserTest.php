<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\UserController;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IndexUserTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker() {
        $this->faker = $this->makeFaker('nl_NL');
    }

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
