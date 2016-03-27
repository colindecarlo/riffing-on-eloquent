<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recommendation extends Model
{
    public function to()
    {
        return $this->belongsTo(User::class);
    }

    public function by()
    {
        return $this->belongsTo(User::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function accept()
    {
        DB::transaction(function () {
            $this->accepted = true;
            $this->save();

            $subscription = (new Subscription)->user()->associate($this->to)->blog()->associate($this->blog);
            $this->subscription()->save($subscription);
        });
    }
}
