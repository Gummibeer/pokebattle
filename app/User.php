<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'bot',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'int',
        'experience' => 'int',
        'wins' => 'int',
        'looses' => 'int',
        'kills' => 'int',
        'deaths' => 'int',
        'bot' => 'bool',
    ];

    public function battlemessages()
    {
        return $this->hasMany(Battlemessage::class, 'user_id', 'id');
    }

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'user_pokemon', 'user_id', 'pokemon_id');
    }

    public function pokemon()
    {
        return $this->pokemons()->wherePivot('active', 1)->withPivot('experience');
    }

    public function getPokemonAttribute()
    {
        return $this->pokemon()->first();
    }

    public function getEffectivenessAgainst($user)
    {
        $effectiveness = 0;
        if (is_numeric($user)) {
            $user = User::find($user);
        } elseif (is_string($user)) {
            $user = User::name($user)->first();
        }

        if ($user instanceof User) {
            foreach ($this->pokemon->types as $causeType) {
                foreach ($user->pokemon->types as $aimType) {
                    $effectiveness += $causeType->getEffectivenessAgainst($aimType);
                }
            }
        }
        return $effectiveness;
    }

    public function won($experience, $isAttacker)
    {
        $this->addExperience($experience);
        $this->increment('wins');
        if ($isAttacker) {
            $this->increment('kills');
        }
        if ($this->kills % 10 == 0) {
            $this->increment('experience');
        }

        Battlemessage::create([
            'user_id' => $this->id,
            'message_key' => 'win',
            'data' => [
                'winner' => $this->pokemon->id,
            ],
        ]);
    }

    public function loose($isAttacker)
    {
        $this->increment('looses');
        if ($isAttacker) {
            $this->resetExperience();
            $this->increment('deaths');
        }

        Battlemessage::create([
            'user_id' => $this->id,
            'message_key' => 'loose',
            'data' => [
                'looser' => $this->pokemon->id,
            ],
        ]);
    }

    public function addExperience($amount)
    {
        $this->pokemons()->sync([
            $this->pokemon->id => [
                'experience' => $this->pokemon->pivot->experience + $amount,
            ]
        ], false);
    }

    public function resetExperience()
    {
        $this->pokemons()->sync([
            $this->pokemon->id => [
                'experience' => 0,
            ]
        ], false);
    }

    public function avatar($size = 64)
    {
        return 'https://gravatar.com/avatar/' . md5($this->email) . '?d=mm&s=' . $size;
    }

    public function scopeBot($query)
    {
        return $query->where('bot', true);
    }
}
