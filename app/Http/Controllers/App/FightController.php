<?php
namespace App\Http\Controllers\App;

use App\Battlehistory;
use App\Http\Controllers\Controller;
use App\Libs\PokemonFight;
use App\Pokemon;
use App\Type;
use App\User;
use Carbon\Carbon;

class FightController extends Controller
{
    protected $trainers = [
        'Ethan',
        'Brendan',
        'Lucas',
        'Hilbert',
        'Nate',
        'Calem',
        'Kris',
        'May',
        'Leaf',
        'Dawn',
        'Lyra',
        'Hilda',
        'Rosa',
        'Serena',
        'Wes',
        'Michael',
        'Mark',
        'Mint',
        'Lunick',
        'Kellyn',
        'Ben',
        'Solana',
        'Kate',
        'Summer',
    ];

    public function getIndex()
    {
        if(\Auth::User()->fightable_at->diffInSeconds(Carbon::now(), false) >= 0) {
            $bot = new User([
                'name' => collect($this->trainers)->random() . ' [BOT]',
                'bot' => true,
            ]);
            $bot->pokemon = \App\Pokemon::starter()->get()->random();
            $bot->experience = getNeededExpByLevel(getCurLvl(\Auth::User()) - floor(rand(1, 3)), $bot);
            $fight = new PokemonFight(\Auth::User(), $bot);
            $fight->run();
            \Auth::User()->save();
            if (\Auth::User() == $fight->getWinner()) {
                \Auth::User()->fightable_at = Carbon::now()->addMinutes(2);
                \Auth::User()->pokemons()->attach($bot->pokemon->id);
                $this->messages->add('battle', trans('messages.fight_won', ['trainer' => $bot->name, 'pokemon' => $bot->pokemon->display_name]));
            } else {
                \Auth::User()->fightable_at = Carbon::now()->addMinutes(4);
                $this->messages->add('battle', trans('messages.fight_lost', ['trainer' => $bot->name, 'pokemon' => $bot->pokemon->display_name]));
            }
        } else {
            $this->messages->add('battle', trans('messages.battle_timeout'));
        }
        return back()->with(['messages' => $this->messages]);
    }

    public function getCatch()
    {
        if(\Auth::User()->fightable_at->diffInSeconds(Carbon::now(), false) >= 0) {
            $catchChance = \Auth::User()->level + mt_rand(-50, 50);

            $bot = new User([
                'name' => collect($this->trainers)->random() . ' [BOT]',
                'bot' => true,
            ]);
            $pokemons = Pokemon::selectRaw('*, ceil(pow(experience, 1.2)) as catch_level')->whereNotIn('id', \Auth::User()->pokemons()->lists('id'))->having('catch_level', '<=' , $catchChance)->get();
            if($pokemons->count() > 0) {
                $bot->pokemon = $pokemons->random();
                $bot->experience = getNeededExpByLevel(getCurLvl(\Auth::User()) + floor(rand(5, 10)), $bot);
                $fightChance = round(mt_rand(1, 10));
                if($fightChance <= 5) {
                    $fight = new PokemonFight(\Auth::User(), $bot);
                    $fight->run();
                    if (\Auth::User() == $fight->getWinner()) {
                        \Auth::User()->fightable_at = Carbon::now()->addMinutes(5);
                        \Auth::User()->pokemons()->attach($bot->pokemon->id);
                        $this->messages->add('battle', trans('messages.catch_success', ['pokemon' => $bot->pokemon->display_name]));
                    } else {
                        \Auth::User()->fightable_at = Carbon::now()->addMinutes(10);
                        $this->messages->add('battle', trans('messages.catch_lost', ['pokemon' => $bot->pokemon->display_name]));
                    }
                } else {
                    \Auth::User()->fightable_at = Carbon::now()->addMinutes(1);
                    $this->messages->add('battle', trans('messages.catch_escape', ['pokemon' => $bot->pokemon->display_name]));
                }
            } else {
                \Auth::User()->fightable_at = Carbon::now()->addSeconds(30);
                $this->messages->add('battle', trans('messages.catch_no_found'));
            }
        } else {
            $this->messages->add('battle', trans('messages.battle_timeout'));
        }
        \Auth::User()->save();
        return back()->with(['messages' => $this->messages]);
    }
}