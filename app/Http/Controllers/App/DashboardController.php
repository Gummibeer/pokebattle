<?php
namespace App\Http\Controllers\App;

use App\Battlehistory;
use App\Http\Controllers\Controller;
use App\Libs\PokemonFight;
use App\Type;
use App\User;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard')->with([
            'types' => Type::all(),
            'battlehistories' => Battlehistory::orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }
}