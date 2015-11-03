<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Battlemessage extends Model
{
    protected $table = 'battlemessages';

    protected $fillable = [
        'user_id',
        'message_key',
        'data',
    ];

    protected $hidden = [];

    protected $appends = [
        'message',
    ];

    protected $casts = [
        'id' => 'int',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getMessageAttribute()
    {
        return trans('battlemessages.'.$this->message_key, $this->data);
    }

    public function getDataAttribute($value)
    {
        $data = [];
        foreach(json_decode($value, true) as $key => $val) {
            $data[$key] = $this->dataKeyToModel($key, $val);
        }
        return $data;
    }

    private function dataKeyToModel($key, $value)
    {
        if(in_array($key, ['attacker', 'defender', 'winner', 'looser'])) {
            return Pokemon::find($value)->display_name;
        } elseif(in_array($key, ['move'])) {
            return Move::find($value)->display_name;
        } else {
            return $value;
        }
    }
}
