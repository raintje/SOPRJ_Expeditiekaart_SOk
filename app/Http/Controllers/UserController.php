<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        //
    }


    public function store(Request $request)
    {
        //
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
