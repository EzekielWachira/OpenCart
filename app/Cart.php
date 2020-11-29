<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product() {
        return $this->hasOne(Product::class);
    }
}
