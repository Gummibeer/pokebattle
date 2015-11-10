<?php
namespace App\Http\Controllers;

use App\Battlehistory;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        view()->share('battlemessages', \Auth::User()->battlemessages()->orderBy('created_at', 'desc')->limit(50)->get());
        view()->share('battlehistories', Battlehistory::orderBy('created_at', 'desc')->limit(50)->get());
        view()->share('highscores', User::player()->orderBy('experience', 'desc')->get());
    }
}
