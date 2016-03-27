<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sentRecommendations()
    {
        return $this->hasMany(Recommendation::class, 'by_id');
    }

    public function receivedRecommendations()
    {
        return $this->hasMany(Recommendation::class, 'to_id');
    }

    public function recommend($blog, $toUser)
    {
        $recommendation = (new Recommendation)->associateWith([
            'to' => $toUser,
            'blog' => $blog,
        ]);
        return $this->sentRecommendations()->save($recommendation);
    }
}
