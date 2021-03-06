# PokéBattle

## Resources

* [Laravel](http://laravel.com)
* [Larachat](https://larachat.slack.com)
* [pokeapi](http://pokeapi.co)
* [veekun/pokedex](https://github.com/veekun/pokedex)
* [Pokestadium](http://www.pokestadium.com)
* [Stackoverflow](http://stackoverflow.com)
* [Amaretti](https://wrapbootstrap.com/theme/amaretti-responsive-admin-template-WB0696K5S)
* [dragonflycave](http://www.dragonflycave.com/stats.aspx) - will come
* [bulbagarden](http://cdn.bulbagarden.net/upload/4/47/DamageCalc.png) - will come
* [OpenWeatherMap](http://openweathermap.org) - will come

## Calculations

* **HP** `= floor((2 * base) * curLevel / 100 + curLevel + 10)`
* **ATK** `= floor((2 * base) * curLevel / 100 + 5)`
* **DEF** `= floor((2 * base) * curLevel / 100 + 5)`
* **SPD** `= floor((2 * base) * curLevel / 100 + 5)`
* **Damage** `= floor((2 * curLevel + 10) * (ownATK / enemyDEF) + 2) * (Power / 100)`
* **received EXP** `= max(floor(((curLevel / 2) + 5 + (enemyLevel - curLevel), 0)`
* **Rank** `= floor((curEXP + permEXP) * min(max(((kills /deaths), 0.8), 1.2))`

## Rules

* A died Pokemon looses all it's experience.
* Every 10 kills the permanent Trainer-Experience increases by 1.