<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Panoscape\History\History;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;
use Throwable;

class DashboardController extends Controller
{

    public function index()
    {
        if (!Auth::user()->hasRole('super admin')) {
            abort(403);
        }

        $itemHistories = $this->getItemHistories();

        try {
            $analyticsData = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
            $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::days(30),  $maxResults = 10);
            $dates = $analyticsData->pluck('date');
            $visitors = $analyticsData->pluck('visitors');

            $dates = $dates->map(function ($date) {
                return Carbon::parse($date)->format('d/m/Y');
            });
        } catch (Throwable  $e) {
            Log::error($e);
            $visitors = [];
            $dates= [];
            $mostVisitedPages = $collection = collect(['product_id' => '',]);
        }


        return view('dashboard.index', compact(['itemHistories', 'visitors', 'dates', 'mostVisitedPages']));
    }

    public function getItemHistories()
    {
        $histories = History::latest('performed_at')->take(10)->get();
        return $histories;
    }

}
