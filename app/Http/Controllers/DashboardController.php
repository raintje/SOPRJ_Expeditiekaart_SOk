<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Panoscape\History\History;

class DashboardController extends Controller
{

    public function index()
    {
        $histories = $this->getItemHistories();
        return view('dashboard.index', ['itemHistories' => $histories]);
    }

    public function getItemHistories()
    {
        return History::latest('performed_at')->take(10)->get();
    }

}
