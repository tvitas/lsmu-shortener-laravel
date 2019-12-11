<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    protected $fillable = [
        'url',
        'identifier',
        'user_id',
        'tags',
        'expires',
        'active',
    ];

    protected $casts = [
        'expires' => 'datetime',
    ];

    protected $purifyable = [
        'url',
        'tags',
    ];

    public function getPurifyable()
    {
        return $this->purifyable;
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
