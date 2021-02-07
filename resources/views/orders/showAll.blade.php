@extends('layouts.main')
@section('content')
    @if(isset($orders) and !empty($orders))
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @component('components.ordersNav')
                            @endcomponent
                            @if(isset($title))
                                <h1>{{$title}}</h1>
                                @endif
                            <table>
                                <tr>
                                    <th>#</th>
                                    <th>Ид</th>
                                    <th>Партнер имя</th>
                                    <th>Стоимость заказа</th>
                                    <th>Состав заказа</th>
                                    <th>Статус</th>
                                </tr>
                                @foreach($orders as $key => $order)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td><a href="{{route('orders.edit', ['id' => $order->id])}}">{{$order->id}}</a></td>

                                        <td>{{$order->partner->name}}</td>
                                        <td>{{$order->totalSum()}}</td>
                                        <td>
                                            @foreach($order->products as $oneProduct)
                                                <p>{{$oneProduct->vendor->name}}</p>
                                                <p>ID {{$oneProduct->id}}</p>
                                                <p>Name {{$oneProduct->name}}</p>
                                                <p>Price {{$oneProduct->price}}</p>
                                                <p>Кол-во {{$order->getCount($oneProduct->id)}}</p>
                                                <hr>
                                            @endforeach
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case(0)
                                                    Новый
                                                @break

                                                @case(10)
                                                    Подтвержден
                                                @break

                                                @case(20)
                                                    Завершен
                                                @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>


    @else
    <h2>Заказов нет</h2>
    @endif

@stop
