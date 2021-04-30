<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

     protected $fillable = [
         'client_email', 'partner_id' , 'status'
     ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products',
                        'order_id', 'product_id');
    }

    public function partner()
    {
        return $this->hasOne('App\Partner', 'id', 'partner_id');
    }

    public function getCount($productId)
    {
        return $this->hasOne('App\OrderProduct', 'order_id', 'id')
            ->where('product_id', '=', $productId)->first()->quantity;
    }

    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }

    public function totalSum()
    {
        $price = 0;
        $data = $this->orderProducts()->get();
        foreach ($data as $one){
            $price += $one->quantity * $one->price;
        }
        return $price;
    }
}
