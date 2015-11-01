<?php
// EXP
if (!function_exists('getCurExp')) {
    function getCurExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return $user->experience + $user->pokemon->pivot->experience;
    }
}

if (!function_exists('getRelativeCurExp')) {
    function getRelativeCurExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return getCurExp($user) - getLastExp($user);
    }
}

if (!function_exists('getNeededExp')) {
    function getNeededExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return getNeededExpByLevel(getCurLvl($user), $user);
    }
}

if (!function_exists('getRelativeNeededExp')) {
    function getRelativeNeededExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return getNeededExp($user) - getLastExp($user);
    }
}

if (!function_exists('getLastExp')) {
    function getLastExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return getCurLvl($user) > 1 ? getNeededExpByLevel(getCurLvl($user) - 1, $user) : 0;
    }
}

if (!function_exists('getNeededExpByLevel')) {
    function getNeededExpByLevel($level, \App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor($user->pokemon->experience * pow($level, 1.1));
    }
}

// LEVEL
if (!function_exists('getCurLvl')) {
    function getCurLvl(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return max(ceil(pow(getCurExp($user) / $user->pokemon->experience, 1 / 1.1)), 1);
    }
}

if (!function_exists('getLvlPercentage')) {
    function getLvlPercentage(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(getRelativeCurExp($user) / getRelativeNeededExp($user) * 100);
    }
}

// STATS
if (!function_exists('getHealth')) {
    function getHealth(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->health) * getCurLvl($user) / 100) + getCurLvl($user) + 20);
    }
}

if (!function_exists('getAtk')) {
    function getAtk(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->attack) * getCurLvl($user) / 100) + 5);
    }
}

if (!function_exists('getDef')) {
    function getDef(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->defense) * getCurLvl($user) / 100) + 5);
    }
}

if (!function_exists('getSpd')) {
    function getSpd(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->speed) * getCurLvl($user) / 100) + 5);
    }
}