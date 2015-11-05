<?php
namespace App\Http\Controllers\App;

use App\Battlehistory;
use App\Http\Controllers\Controller;
use App\Libs\PokemonFight;
use App\Type;
use App\User;
use Carbon\Carbon;

class FightController extends Controller
{
    public function getIndex()
    {
        $fight = new PokemonFight(\Auth::User(), User::where('id', '<>', \Auth::User()->id)->get()->random());
        $fight->run();
        return back();
    }
}