<?php

namespace App\Http\Controllers;

use App\Order;

class OrdersController extends Controller
{
    public function showAll(){
        return 'Use Admin\OrdersController';
    }
    public function showOne(int $id){
        return 'Use Admin\OrdersController' . $id;
    }
}
