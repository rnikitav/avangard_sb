<?php

namespace App\Listeners;

use App\Mail\OrderStatusFinishedMailClass;
use App\Order;
use Illuminate\Support\Facades\Mail;

class SendEmailForFinishedStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if (isset($event) && $event->order instanceof Order) {
            $emailArr = [];
            array_push($emailArr, $event->order->partner()->first()->email);
            $products = $event->order->products()->get();
            foreach ($products as $product) {
                array_push($emailArr, $product->vendor()->first()->email);
            }
            Mail::to($emailArr)
                ->send(new OrderStatusFinishedMailClass($event->order));
        }
        return redirect(route('main'));
    }
}
