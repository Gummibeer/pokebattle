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

    public function getNameAttribute($value)
    {
        return trans('types.'.$value);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
