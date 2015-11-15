<?php
namespace App\Http\Controllers;

use App\Battlehistory;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\MessageBag;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->messages = is_null(session('messages')) ? new MessageBag() : session('messages');

        view()->share('messages', $this->messages);
        view()->share('battlemessages', \Auth::User()->battlemessages()->orderBy('created_at', 'desc')->limit(50)->get());
        view()->share('battlehistories', Battlehistory::orderBy('created_at', 'desc')->limit(50)->get());
        view()->share('highscores', User::player()->orderBy('experience', 'desc')->get());
    }
}
