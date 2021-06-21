<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Panoscape\History\History;

class DashboardController extends Controller
{

    public function index()
    {
        $histories = $this->getItemHistories();
        if (!Auth::user()->hasRole('super admin')) {
            abort(403);
        }

        return view('dashboard.index', ['itemHistories' => $histories]);
    }

    public function getItemHistories()
    {
        $histories = History::latest('performed_at')->take(10)->get();
        return $histories;
    }

}
