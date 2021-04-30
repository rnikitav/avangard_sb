<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';

    public function getProduct()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
