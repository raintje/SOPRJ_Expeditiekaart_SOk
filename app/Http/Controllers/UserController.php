<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;
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


    public function store(UserStoreRequest $request)
    {
        $request->merge(['password' => Hash::make(Str::random(10))]);
        $user = User::create($request->all());

        if ($user->exists)
        {
            try {
                Password::broker()->sendResetLink(['email' => $user->email]);
                $message = ['message' =>'Gebruikersaccount succesvol aangemaakt', 'type' => 'success'];
            } catch (Throwable $e) {
                Log::error($e);
                $message = ['message' =>'Er is iets fout gegaan, neem contact op met de sitebeheerder', 'type' => 'danger'];
            }
        }
        else{
            $message = ['message' =>'Er is iets fout gegaan, probeer het opnieuw.', 'type' => 'danger'];
        }

        return redirect()->route('users.index')->with($message);
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
//        $request->merge(['password' => Hash::make($request->password)]);
//
//        $user = User::finfOrFail($id);
//        $user->fill($request->all())->save();
//
//        if ($user->exists)
//        {
//            Password::broker()->sendResetLink(['email' => $user->email]);
//        }
//
//        return redirect()->route('users')->with('message', 'success:Gebruikersaccount succesvol aangepast');
    }

    public function destroy($id)
    {
        //
    }
}
