<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return " <div  class='d-flex'>
                                <a  href='#' class='m-auto btn btn-outline-primary btn-xs pl-2'>aanpassen</a>
                            </div>";
                })
                ->addColumn('extra', function () {
                    return "<div class='text-center'><i data-toggle='modal' data-target='#exampleModal' class='delete-icon far fa-trash-alt'></i></div>";
                })
                ->rawColumns(['action', 'body', 'extra'])
                ->make(true);
        }
        return null;
    }


    public function create()
    {
        return view('users.create');
    }


    /**
     * Saves a newly created user to the database.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        // Get the validated data from the request
        $validated = $request->validated();

        // Initialize the model object to be inserted into the database
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        // Generates a random hashed password of 8 characters.
        $user->password = Hash::make(Str::random(8));

        // Save the object to the database
        $user->save();

        // Redirects to the user overview
        return redirect()->route('users');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
