@extends('layouts.main')
@section('content')
    <div class="col-8 offset-2">



        <h3>Редактировать заказа с #ID = {{ $order->id }}</h3>
        <br>
        <form method="post" action="{{ route('orders.update', ['order' => $order]) }}">
            {{method_field('PUT')}}
            {{ csrf_field() }}
            <p>Ид Заказа:  <strong>{{$order->id}}</strong></p>

            <p>Email клиеннта: <br><input class="form-control" name="client_email" value="{{ $order->client_email }}" >
            @if($errors->has('client_email'))
                <div class="alert alert-danger">
                    @foreach($errors->get('client_email') as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif
            <p>Партнер: <br>
                <select name="partner_id" class="form-control">
                    <option value="{{$order->partner_id}}" selected>{{$order->partner->name}}</option>
                    @if(isset($partnersList))
                        @foreach($partnersList as $partner)
                            <option value="{{$partner->id}}">{{$partner->name}}</option>
                        @endforeach
                    @endif
                </select>
            @if($errors->has('partner_id'))
                <div class="alert alert-danger">
                    @foreach($errors->get('partner_id') as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif
            <table>
                <tr>
                    <th>Имя</th>
                    <th>Количество</th>
                </tr>
                @foreach($order->products as $oneProduct)
                <tr>
                    <th>{{$oneProduct->name}}</th>
                    <th>{{$order->getCount($oneProduct->id)}}</th>
                </tr>
                @endforeach
            </table>
            <p>Статус: <br>
                <select name="status" class="form-control">
                    <option value="{{$order->status}}" selected>{{$order->status}}</option>
                    @if(isset($statusList))
                        @foreach($statusList as $one)
                            <option value="{{$one['status']}}">{{$one['status']}}</option>
                        @endforeach
                    @endif
                </select>
            @if($errors->has('status'))
                <div class="alert alert-danger">
                    @foreach($errors->get('status') as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif
                <p>Стоимость заказа: <strong>{{$order->totalSum()}}</strong></p>

            <button class="btn btn-success" type="submit">Редактировать</button>
        </form>
    </div>
@stop
