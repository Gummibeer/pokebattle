<?php
if(!function_exists('getCurExp')) {
    function getCurExp(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return $user->experience + $user->pokemon->pivot->experience;
    }
}

if(!function_exists('getRelativeCurExp')) {
    function getRelativeCurExp(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return getCurExp($user) - getLastExp($user);
    }
}

if(!function_exists('getNeededExp')) {
    function getNeededExp(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor($user->pokemon->experience * pow(2, (getCurLvl($user) - 1)));
    }
}

if(!function_exists('getRelativeNeededExp')) {
    function getRelativeNeededExp(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return getNeededExp($user) - getLastExp($user);
    }
}

if(!function_exists('getLastExp')) {
    function getLastExp(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return getCurLvl($user) > 1 ? floor($user->pokemon->experience * pow(2, (getCurLvl($user) - 2))) : 0;
    }
}

if(!function_exists('getCurLvl')) {
    function getCurLvl(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return max(ceil((log(getCurExp($user) / $user->pokemon->experience) / log(2)) + 1), 1);
    }
}

if(!function_exists('getLvlPercentage')) {
    function getLvlPercentage(\App\User $user = null) {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(getRelativeCurExp($user) / getRelativeNeededExp($user) * 100);
    }
}