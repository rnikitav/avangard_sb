@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <h1>Погода {{$data->city->name}}</h1>
                    <div class="panel-body">
                        <div class="weather__time">
                            <p>{{$time}}</p>
                            <p>{{$data->list[0]->weather[0]->description}}</p>
                            <p>Мин {{$data->list[0]->main->temp_min}} С</p>
                            <p>Макс {{$data->list[0]->main->temp_max}} С</p>
                            <p>Влажность {{$data->list[0]->main->humidity}} %</p>
                            <p>Сейчас {{$data->list[0]->main->temp}} С</p>
                            <p>Ветер {{$data->list[0]->wind->speed}} км/ч</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
