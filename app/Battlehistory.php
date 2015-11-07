<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Battlehistory extends Model
{
    protected $table = 'battlehistories';

    protected $fillable = [
        'attacker_user_id',
        'attacker_pokemon_id',
        'defender_user_id',
        'defender_pokemon_id',
        'attacker_win',
        'rounds',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'int',
        'attacker_user_id' => 'int',
        'attacker_pokemon_id' => 'int',
        'defender_user_id' => 'int',
        'defender_pokemon_id' => 'int',
        'rounds' => 'int',
        'attacker_win' => 'bool',
    ];

    public function attacker()
    {
        return $this->hasOne(User::class, 'id', 'attacker_user_id');
    }

    public function attackerPokemon()
    {
        return $this->hasOne(Pokemon::class, 'id', 'attacker_pokemon_id');
    }

    public function defender()
    {
        return $this->hasOne(User::class, 'id', 'defender_user_id');
    }

    public function defenderPokemon()
    {
        return $this->hasOne(Pokemon::class, 'id', 'defender_pokemon_id');
    }

    public function scopeUser($query, $userId)
    {
        return $query->where('attacker_user_id', $userId)->orWhere('defender_user_id', $userId);
    }
}
