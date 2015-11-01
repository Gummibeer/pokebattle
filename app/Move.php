<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    protected $table = 'moves';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'power',
    ];
    protected $hidden = [];
    protected $appends = [
        'display_name',
    ];

    protected $casts = [
        'id' => 'int',
        'power' => 'int',
    ];

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_move', 'move_id', 'pokemon_id');
    }

    public function getDisplayNameAttribute()
    {
        return trans('moves.' . $this->name);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
