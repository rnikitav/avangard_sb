<h1> ID заказа  {{$order->id}}  </h1>
@foreach($order->orderProducts as $one)
    <p>Наименование : {{$one->getProduct->name}}</p>
    <p>Количество : {{$one->quantity}}</p>
    <p>Цена :  {{$one->price}}  &#8381; </p>
    <hr>
@endforeach
<h3>Общая сумма заказа:  {{$order->totalSum()}} &#8381;</h3>
