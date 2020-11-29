<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    public function product() {
        return $this->hasOne(Product::class);
    }
}
