<?php
namespace App\Http\Controllers\App;

use App\Battlehistory;
use App\Http\Controllers\Controller;
use App\Libs\PokemonFight;
use App\Type;
use App\User;
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
            'highscores' => User::player()->get()->sortByDesc('level'),
        ]);
    }
    public function getFight()
    {
        $fight = new PokemonFight(\Auth::User(), User::where('id', '<>', \Auth::User()->id)->get()->random());
        $fight->run();
        return back();
    }
}