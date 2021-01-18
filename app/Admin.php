<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
//    protected $fillable = [
//
//    ]

    public function user() {
        return $this->hasOne(User::class);
    }
}
