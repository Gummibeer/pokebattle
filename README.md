# PokeBattle

## Resources

* [Laravel](http://laravel.com)
* [veekun/pokedex](https://github.com/veekun/pokedex)
* [pokeapi](http://pokeapi.co)
* [dragonflycave]http://www.dragonflycave.com/stats.aspx

## Calculations

* **HP** `= floor((2 * base) * curLevel / 100 + curLevel + 10)`
* **ATK** `= floor((2 * base) * curLevel / 100 + 5)`
* **DEF** `= floor((2 * base) * curLevel / 100 + 5)`
* **SPD** `= floor((2 * base) * curLevel / 100 + 5)`

* **needed EXP** `= floor(base * 2 ^ (curLevel - 1))`
* **received EXP** `= 0 < floor((curLevel / 2) + 5 + (enemyLevel - curLevel)`

## Rules

* A died Pokemon looses all it's experience.
* Every 10 kills the permanent Trainer-Experience increases by 1.