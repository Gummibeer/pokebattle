<?php
namespace App\Http\Controllers\App;

use App\Pokemon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PokedexController extends Controller
{
    public function getIndex()
    {
        return view('app.pokedex.index')->with([
            'pokemons' => Pokemon::paginate(50),
        ]);
    }
}