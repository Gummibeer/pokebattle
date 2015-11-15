<?php
namespace App\Http\Controllers\App;

use App\Battlehistory;
use App\Http\Controllers\Controller;
use App\Libs\PokemonFight;
use App\Type;
use App\User;
use Carbon\Carbon;

class PokemonController extends Controller
{
    public function postChange()
    {
        $newPokemonId = \Input::get('pokemon_id');
        $newPokemon = \Auth::User()->pokemons()->findOrFail($newPokemonId);
        \Auth::User()->pokemons()->sync([\Auth::User()->pokemon->id => ['active' => false]], false);
        \Auth::User()->pokemons()->sync([$newPokemon->id => ['active' => true]], false);
        $this->messages->add('pokemon', trans('messages.pokemon_change', ['pokemon' => \Auth::User()->pokemon->display_name]));
        return back()->with(['messages' => $this->messages]);
    }
}