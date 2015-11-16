<?php
// EXP
if (!function_exists('getCurExp')) {
    function getCurExp(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return object_get($pokemon, 'pivot.experience', 0);
    }
}

if (!function_exists('getRelativeCurExp')) {
    function getRelativeCurExp(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return getCurExp($user, $pokemon) - getLastExp($user, $pokemon);
    }
}

if (!function_exists('getNeededExp')) {
    function getNeededExp(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return getNeededExpByLevel(getCurLvl($user, $pokemon), $user, $pokemon);
    }
}

if (!function_exists('getRelativeNeededExp')) {
    function getRelativeNeededExp(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return getNeededExp($user, $pokemon) - getLastExp($user, $pokemon);
    }
}

if (!function_exists('getLastExp')) {
    function getLastExp(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return getCurLvl($user, $pokemon) > 1 ? getNeededExpByLevel(getCurLvl($user, $pokemon) - 1, $user, $pokemon) : 0;
    }
}

if (!function_exists('getNeededExpByLevel')) {
    function getNeededExpByLevel($level, \App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return floor($pokemon->experience * pow($level, 1.2));
    }
}

// LEVEL
if (!function_exists('getCurLvl')) {
    function getCurLvl(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return max(ceil(pow(getCurExp($user, $pokemon) / $pokemon->experience, 1 / 1.2)), 1);
    }
}

if (!function_exists('getLvlPercentage')) {
    function getLvlPercentage(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return floor(getRelativeCurExp($user, $pokemon) / getRelativeNeededExp($user, $pokemon) * 100);
    }
}

// STATS
if (!function_exists('getHealth')) {
    function getHealth(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return ceil(((2 * ($pokemon->health - $user->bot)) * (getCurLvl($user, $pokemon) / 10)) + 30 - $user->bot);
    }
}

if (!function_exists('getAtk')) {
    function getAtk(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return floor(((2 * ($pokemon->attack - $user->bot)) * getCurLvl($user, $pokemon) / 100) + 5 - $user->bot);
    }
}

if (!function_exists('getDef')) {
    function getDef(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return floor(((2 * $pokemon->defense - $user->bot) * getCurLvl($user, $pokemon) / 100) + 5 - $user->bot);
    }
}

if (!function_exists('getSpd')) {
    function getSpd(\App\User $user = null, \App\Pokemon $pokemon = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        $pokemon = is_null($pokemon) ? $user->pokemon : $pokemon;
        return floor(((2 * $pokemon->speed - $user->bot) * getCurLvl($user, $pokemon) / 100) + 5 - $user->bot);
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

if (!function_exists('lurl')) {
    function lurl($path, $locale = null)
    {
        if (is_null($locale)) $locale = config('app.locale');
        if (!in_array($locale, config('app.supported_locales'))) $locale = config('app.locale');

        return url($locale . '/' . $path);
    }
}