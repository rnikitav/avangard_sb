@extends('layouts.main')
@section('content')
    <h1>Заказ с ИД {{$order}}</h1>
    <table>
        <tr>
            <th colspan="2">Модель</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
        </tr>
        <tr>
            <td><img src="https://html5book.ru/wp-content/uploads/2015/04/dress-2.png"></td>
            <td>Платье с цветочным принтом</td>
            <td>{{$order}}</td>
            <td>1</td>
            <td>2500</td>
        </tr>

    </table>
@stop
