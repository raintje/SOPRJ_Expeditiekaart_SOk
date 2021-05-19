<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{

    /**
     * Test to delete user, passes through route, as well as the controller method.
     *
     * @return void
     */
    public function test_delete_user(){
        $user = User::factory()->create();
        $request = Request::create('/users/delete', 'POST',[
            'id'     =>     $user->id,
        ]);
        $controller = new UserController();
        $response = $controller->destroy($request);
        $this->assertEquals(302, $response->getStatusCode());
    }
    /**
     * Test to delete user with wrong/negative information.
     *
     * @return void
     */
    public function test_delete_user_with_wrong_data(){
        $user = User::first();
        Auth::login($user);
        $response = $this->call('post', '/users/delete', ['id' => -1, '_token' => csrf_token()]);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
