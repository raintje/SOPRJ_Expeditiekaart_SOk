<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $histories = History::latest('performed_at')->take(10)->get();
        return $histories;
    }

}
