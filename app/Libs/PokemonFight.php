<?php
namespace App\Libs;

use App\Battlehistory;
use App\User;

class PokemonFight
{
    protected $trainers;
    protected $pokemons;
    protected $roundCount = 0;

    public function __construct(User $attacker, User $defender)
    {
        $this->trainers = collect([
            'attacker' => $attacker->load('pokemon'),
            'defender' => $defender->load('pokemon'),
        ]);
        $this->pokemons = collect([
            $this->getPokemonData($attacker, true),
            $this->getPokemonData($defender, false),
        ])->sortByDesc('speed');
    }

    public function run()
    {
        while ($this->allAlive()) {
            $this->runRound();
            $this->switchOrder();
            $this->roundCount++;
        }
        $this->end();
    }

    public function runRound()
    {
        $move = $this->pokemons->first()['moves']->random();
        $attackerTrainer = $this->getTrainerByPokemon($this->pokemons->first());
        $defenderTrainer = $this->getTrainerByPokemon($this->pokemons->last());
        $defender = $this->pokemons->pop();
        $defender['health'] -= calcDmg($attackerTrainer, $move, $defenderTrainer);
        $this->pokemons->push($defender);
    }

    private function end()
    {
        $winner = $this->pokemons->reject(function ($pokemon) {
            return $pokemon['health'] <= 0;
        })->first();
        $looser = $this->pokemons->filter(function ($pokemon) {
            return $pokemon['health'] <= 0;
        })->first();
        Battlehistory::create([
            'attacker_user_id' => $this->trainers->get('attacker')->id,
            'attacker_pokemon_id' => $this->trainers->get('attacker')->pokemon->id,
            'defender_user_id' => $this->trainers->get('defender')->id,
            'defender_pokemon_id' => $this->trainers->get('defender')->pokemon->id,
            'attacker_win' => $winner['is_attacker'],
            'rounds' => $this->roundCount,
        ]);
        $exp = max(floor((getCurLvl($this->getTrainerByPokemon($winner)) / 2) + 5 + (getCurLvl($this->getTrainerByPokemon($looser)) - getCurLvl($this->getTrainerByPokemon($winner))) + ($winner['is_attacker'] * 2)), 0);
        $this->getTrainerByPokemon($winner)->won($exp, $winner['is_attacker']);
        $this->getTrainerByPokemon($looser)->loose($looser['is_attacker']);
    }

    public function allAlive()
    {
        return (bool)!$this->pokemons->contains(function ($key, $pokemon) {
            return $pokemon['health'] <= 0;
        });
    }

    protected function switchOrder()
    {
        $this->pokemons = $this->pokemons->reverse();
    }

    protected function getPokemonData(User $trainer, $attacker)
    {
        return [
            'is_attacker' => $attacker,
            'trainer_id' => $trainer->id,
            'pokemon_id' => $trainer->pokemon->id,
            'moves' => $trainer->pokemon->moves,
            'health' => getHealth($trainer),
        ];
    }

    protected function getTrainerByPokemon(array $pokemon)
    {
        return $pokemon['is_attacker'] ? $this->trainers->get('attacker') : $this->trainers->get('defender');
    }
}