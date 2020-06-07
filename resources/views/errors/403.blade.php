<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Prohibido</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .half-height {
            height: 50vh;
        }

        .flex-end {
            align-items: flex-end;
            display: flex;
            justify-content: center;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .code {
            border-right: 2px solid;
            font-size: 26px;
            padding: 0 15px 0 15px;
            text-align: center;
        }

        .message {
            font-size: 18px;
            padding: 5px 10px 6px 10px;
            text-align: center;
        }

        .mylink {
            color: white;
            background-color: #636b6f;
            padding: 15px 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
            border: 1px solid;
        }
    </style>
</head>

<body>
    <div class="flex-end position-ref half-height">
        <div class="code">403</div>
        <div class="message">Acceso no autorizado
        </div>
    </div>

    <div class="flex-center position-ref half-height">
        @auth
        <a class="mylink" href="{{ url('logout') }}" style="margin-right:10px">Login</a>
        @else
        <a class="mylink" href="{{ route('login') }}" style="margin-right:10px">Login</a>
        @endauth
        <a class="mylink" href="{{ route('home') }}" style="margin-left:10px">Inicio</a>
    </div>
</body>

</html>