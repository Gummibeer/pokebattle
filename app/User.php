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
    ];

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'user_pokemon', 'user_id', 'pokemon_id');
    }

    public function pokemon()
    {
        return $this->pokemons()->wherePivot('active', 1);
    }

    public function getPokemonAttribute()
    {
        return $this->pokemon()->withPivot('experience')->first();
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
