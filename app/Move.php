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

    protected $casts = [
        'id' => 'int',
        'power' => 'int',
    ];

    public function getNameAttribute($value)
    {
        return trans('types.' . $value);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }
}
