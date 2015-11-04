<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Pokemon extends Model
{
    protected $table = 'pokemons';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'health',
        'attack',
        'defense',
        'speed',
        'experience',
    ];
    protected $hidden = [];

    protected $appends = [
        'avatar',
        'display_name',
    ];

    protected $casts = [
        'id' => 'int',
        'health' => 'int',
        'attack' => 'int',
        'defense' => 'int',
        'speed' => 'int',
        'experience' => 'int',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'pokemon_type', 'pokemon_id', 'type_id');
    }

    public function moves()
    {
        return $this->belongsToMany(Move::class, 'pokemon_move', 'pokemon_id', 'move_id');
    }

    public function trainers()
    {
        return $this->belongsToMany(User::class, 'user_pokemon', 'pokemon_id', 'user_id');
    }

    public function getAvatarAttribute()
    {
        $path = 'pokemons/' . $this->id . '.png';
        if (!\Storage::disk('public')->exists($path)) {
            \Storage::disk('public')->put($path, file_get_contents('http://www.pokestadium.com/assets/img/sprites/' . $this->id . '.png'));
        }
        if (\Storage::disk('public')->exists($path)) {
            return url('storage/' . $path);
        }
    }

    public function getDisplayNameAttribute()
    {
        return transd('pokemons.' . $this->name, $this->name);
    }

    public function catched(User $user = null)
    {
        $user = is_null($user) ? \Auth::User() : $user;
        return (bool) $this->trainers()->where('id', $user->id)->count();
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function scopeStarter($query)
    {
        return $query->whereIn('id', [1, 4, 7, 25, 152, 155, 158, 252, 255, 258, 495, 498, 501]);
    }
}
