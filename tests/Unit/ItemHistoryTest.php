<?php

namespace Tests\Unit;

use App\Http\Controllers\LayerItemController;
use App\Http\Requests\LayerItemEditRequest;
use App\Models\LayerItem;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Panoscape\History\History;
use Tests\TestCase;

class ItemHistoryTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRestoreItemHistoryWithWrongID()
    {
        $user = User::first();
        $lastHistory = History::latest('performed_at')->first();
        if($lastHistory == null){
            $id = 1;
        }
        else{
            $id = $lastHistory->id+1;
        }
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('restore.item', $id));
        $response->assertStatus(404);
    }

    public function testDeleteItemHistoryWithWrongID()
    {
        $user = User::first();
        $lastHistory = History::latest('performed_at')->first();
        if($lastHistory == null){
            $id = 1;
        }
        else{
            $id = $lastHistory->id+1;
        }
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('destroy.itemHistory', $id));
        $response->assertStatus(404);
    }

    public function testRestoreItemHistoryWithCorrectID()
    {
        $user = User::first();
        Auth::login($user);

        $rndmItemId = $this->faker->randomElement(LayerItem::all())->id;
        $response = $this->post(route('update.item', ['id' => $rndmItemId]), [
            'title' => $this->faker->title,
            'body' => 'test'
        ]);

        $this->assertEquals(302, $response->getStatusCode());

        $lastHistory = History::latest('performed_at')->first();
        dd($lastHistory);
        $id = $lastHistory->id;
        $this->assertAuthenticated();
        $response = $this->get(route('restore.item', $id));
        $response->assertStatus(404);
    }

    public function testDeleteItemHistoryWithCorrectID()
    {

    }

}
