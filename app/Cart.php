<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product() {
        return $this->hasMany(Product::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
