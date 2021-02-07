<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Главная</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-5">
            <div class="panel panel-default">
                <div class="links">
                    <a style="margin: 20px" class="dropdown-item" href="{{ route('main') }}">Личный кабинет</a>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</div>

</body>
</html>
