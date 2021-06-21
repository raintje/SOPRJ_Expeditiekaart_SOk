<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleAssignRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\UserDeleteMail;
use App\Http\Requests\UserUpdatePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\UserUpdateMail;
use App\Mail\UserUpdatePasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
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
                ->addColumn('Rol', function ($row) {
                    $user = User::findOrFail($row->id);
                    return $rol = implode(',', $user->getRoleNames()->toArray());;
                })
                ->addColumn('action', function ($row) {
                    return "<div class='d-flex'>
                                <a href=".route('users.edit', ['user' => $row->id])." class='m-auto btn btn-outline-primary btn-xs pl-2'>aanpassen</a>
                            </div>";
                })
                ->addColumn('extra', function ($row) {
                    return "<div class='text-center'><i data-toggle='modal' dusk='delete$row->id' data-target='#exampleModal' data-id=".$row->id." class='delete-icon far fa-trash-alt addAttr'></i></div>";
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
        else {
            $message = ['message' => 'Er is iets fout gegaan, probeer het opnieuw.', 'type' => 'danger'];
        }

        return redirect()->route('users.index')->with($message);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->hasRole('super admin') ? Role::all() : Role::where('name', '!=', 'super admin')->get();

        return view('users.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->all())->save();

        $details = [
            'name' => $user->name,
            'email' => $user->email
        ];

        Mail::to($user->email)->send(new UserUpdateMail($details));

        $message = ['message' =>'Gebruikersaccount succesvol aangepast', 'type' => 'success'];

        return redirect()->route('users.index')->with($message);
    }

    public function updatePassword(UserUpdatePasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->all())->save();

        if ($user->id != Auth::id())
        {
            $details = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password
            ];

            Mail::to($user->email)->send(new UserUpdatePasswordMail($details));
        }

        $message = ['message' =>'Wachtwoord succesvol aangepast', 'type' => 'success'];

        return redirect()->route('users.index')->with($message);
    }

    public function updateRole(RoleAssignRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();



        foreach ($roles as $role) { $user->removeRole($role); }

        $user->assignRole($request->input('role'));

        return redirect()->route('users.index')->with(['message' =>'Rol toegekend aan gebruiker', 'type' => 'success']);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        $details = [
            'name' => $user->name,
            'email' => $user->email
        ];

        $user->delete();
        Mail::to($user->email)->send(new UserDeleteMail($details));

        if(!$user->exists) {
            $message = ['message' =>'Gebruikersaccount succesvol verwijderd', 'type' => 'success'];
        }
        else{
            $message = ['message' =>'Er is iets fout gegaan, probeer het opnieuw.', 'type' => 'danger'];
        }

        return redirect()->route('users.index')->with($message);
    }
}
