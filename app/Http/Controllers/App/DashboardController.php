<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Move;
use App\Pokemon;
use App\Type;

class DashboardController extends Controller
{
    public function getIndex()
    {
        return view('app.dashboard')->with([
            'types' => Type::all(),
            'pokemonOfTheDay' => Pokemon::first(),
        ]);
    }
}