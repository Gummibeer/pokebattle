<?php
// EXP
if (!function_exists('getCurExp')) {
    function getCurExp(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return $user->experience + object_get($user, 'pokemon.pivot.experience', 0);
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
        return ceil(((2 * ($user->pokemon->health - $user->bot)) * (getCurLvl($user) / 10)) + 30 - $user->bot);
    }
}

if (!function_exists('getAtk')) {
    function getAtk(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * ($user->pokemon->attack - $user->bot)) * getCurLvl($user) / 100) + 5 - $user->bot);
    }
}

if (!function_exists('getDef')) {
    function getDef(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->defense - $user->bot) * getCurLvl($user) / 100) + 5 - $user->bot);
    }
}

if (!function_exists('getSpd')) {
    function getSpd(\App\User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return floor(((2 * $user->pokemon->speed - $user->bot) * getCurLvl($user) / 100) + 5 - $user->bot);
    }
}

// DAMAGE
if (!function_exists('calcDmg')) {
    function calcDmg(\App\User $attacker, \App\Move $move, \App\User $defender)
    {
        return round(((2 * (getCurLvl($attacker) + 10)) * (getAtk($attacker) / getDef($defender)) + 2) * ($move->power / 100) * (1 + (0.5 * (getWeatherEffectiveness($attacker->pokemon->types->pluck('name')->toArray()) + $attacker->getEffectivenessAgainst($defender)))));
    }
}

if (!function_exists('getWeatherEffectiveness')) {
    function getWeatherEffectiveness($type)
    {
        if (is_array($type)) {
            $effectiveness = 0;
            foreach ($type as $t) {
                $effectiveness += getWeatherEffectiveness($t);
            }
            return $effectiveness;
        } else {
            return in_array($type, getWeatherByDate(\Carbon\Carbon::today())['types']) ? 1 : 0;
        }
    }
}

// WEATHER
if (!function_exists('getWeatherByDate')) {
    function getWeatherByDate(\Carbon\Carbon $date)
    {
        $weatherRatio = (array)config('weather.ratio');
        shuffle($weatherRatio);
        return \Cache::rememberForever(str_slug('weather ' . $date->toDateString()), function () use ($weatherRatio) {
            $type = array_get($weatherRatio, rand(0, count($weatherRatio) - 1), 'sun');
            return config('weather.' . $type);
        });
    }
}

// HELPERS
if (!function_exists('transd')) {
    function transd($key, $default = null)
    {
        if (Lang::has($key)) {
            return Lang::trans($key);
        } else {
            return $default;
        }
    }
}