<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
    ];
    protected $hidden = [];

    protected $casts = [
        'id' => 'int',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, 'type_relations', 'cause_type_id', 'aim_type_id');
    }

    public function ineffectives()
    {
        return $this->types()->wherePivot('value', -1);
    }

    public function effectives()
    {
        return $this->types()->wherePivot('value', 1);
    }

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_type', 'type_id', 'pokemon_id');
    }

    public function getEffectivenessAgainst($type)
    {
        if ($type instanceof Type) {
            $effectiveness = 1;
            $effectiveness += $this->ineffectives()->where('id', $type->id)->count() > 0 ? -0.5 : 0;
            $effectiveness += $this->effectives()->where('id', $type->id)->count() > 0 ? 1 : 0;
            return $effectiveness;
        } elseif (is_numeric($type)) {
            return $this->getEffectivenessAgainst(Type::find($type));
        } elseif (is_string($type)) {
            return $this->getEffectivenessAgainst(Type::name($type)->first());
        }
        return 1;
    }

    public function getNameAttribute($value)
    {
        return trans('types.' . $value);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
