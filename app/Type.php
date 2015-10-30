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

    public function getNameAttribute($value)
    {
        return trans('types.' . $value);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
