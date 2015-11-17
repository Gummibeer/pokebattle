<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Type;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard')->with([
            'types' => Type::all(),
            'fights' => collect(\DB::table('battlehistories')->where('created_at', '>=', Carbon::today()->subWeek()->format('Y-m-d'))->selectRaw('id, date(created_at) as day')->get())->groupBy(function ($item) {
                return $item->day;
            })->map(function ($item) {
                return count($item);
            }),
        ]);
    }
}