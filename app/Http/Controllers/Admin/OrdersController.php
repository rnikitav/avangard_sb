<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusEvent;
use App\Http\Requests\OrderUpdate;
use App\Order;
use App\Partner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Словарик для заголовка заказа в зависимости от URL
     * @param int $id
     * @return string
     */
    private function getTitle(int $id){
        $dictionary = [
            0 => 'Новые',
            10 => 'Текущие',
            11 => 'Просроченные',
            20 => 'Выполненные',
        ];
        return $dictionary[$id];
    }
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest('updated_at')->paginate(15);
        return view('orders.showAll', ['orders' => $orders]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function indexWithStatus(int $id = 0)
    {
        $title = $this->getTitle($id);
        if ($id === 0){
            $orders = Order::where([
                ['status', '=', $id],
                ['delivery_dt' , '>', Carbon::now('Europe/Moscow')]
            ])
                ->oldest('delivery_dt')
                ->take(50)->get();;
            return view('orders.showAllNoPaginate', ['orders' => $orders, 'title' => $title]);
        }
        if ($id === 11){
            $status = $id - 1;
            $orders = Order::where([
                        ['status', '=', $status],
                        ['delivery_dt', '<', Carbon::now('Europe/Moscow')]
                    ])
                ->latest('delivery_dt')
                ->take(50)->get();
            return view('orders.showAllNoPaginate', ['orders' => $orders, 'title' => $title]);
        }
        if ($id === 10){
            $orders = Order::where([
                ['status', '=', $id],
                ['delivery_dt', '<=',  Carbon::now('Europe/Moscow')->addHour(24)],
                ['delivery_dt' , '>=', Carbon::now('Europe/Moscow')]
            ])
                ->oldest('delivery_dt')
                ->paginate(15);
            return view('orders.showAll', ['orders' => $orders, 'title' => $title]);
        }

        $orders = Order::where([
            ['status' , '=', $id],
            ['delivery_dt', '>=',  Carbon::today('Europe/Moscow')],
            ['delivery_dt', '<=', Carbon::tomorrow('Europe/Moscow')]
        ])
            ->latest('delivery_dt')
            ->paginate(15);
        return view('orders.showAll', ['orders' => $orders, 'title' => $title]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $partnersList = Partner::where('id', '<>', $order->partner_id)->get();
        $statusList = Order::select('status')->where('status' , '<>', $order->status)->distinct()->get();
        return view('admin.orders.edit', [
            'order' => $order,
            'partnersList' => $partnersList,
            'statusList' => $statusList
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdate $request, Order $order)
    {
        $data = $request->validated();
        $order->fill($data);
        if($order->save()) {
            if ((int)$order->status === 20){
                event(new OrderStatusEvent($order));
            }
            return redirect()->route('orders.Status');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
