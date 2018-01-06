<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>X-Wing ratings</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <table>
            <tr><th>Name</th><th>Score</th><th>SoS</th><th>MoV</th></tr>
            @foreach($event->players as $player)
            <tr><td>{{$player->name}}</td><td>{{$player->score}}</td><td>{{$player->sos}}</td><td>{{$player->mov}}</td></tr>
            @endforeach
        </table>
        <table>
            <tr><th>Name</th><th>Rating</th></tr>
            @foreach($players as $player)
            <tr><td>{{$player->name}}</td><td>{{$player->rating}}</td></tr>
            @endforeach
        </table>
    </body>
</html>
