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
                'experience' => getCurExp(\Auth::User()) - rand(0, 200),
                'bot' => true,
            ]);
            $bot->pokemon = \App\Pokemon::starter()->get()->random();
            $fight = new PokemonFight(\Auth::User(), $bot);
            $fight->run();
            \Auth::User()->fightable_at = Carbon::now()->addSeconds(30);
            \Auth::User()->save();
        }
        return back();
    }
}