<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    {{--    Bootstrap--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
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
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .footer-basic {
            padding: 40px 0;
            background-color: #ffffff;
            color: #4b4c4d;
        }

        .footer-basic ul {
            padding: 0;
            list-style: none;
            text-align: center;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .footer-basic li {
            padding: 0 10px;
        }

        .footer-basic ul a {
            color: inherit;
            text-decoration: none;
            opacity: 0.8;
        }

        .footer-basic ul a:hover {
            opacity: 1;
        }

        .footer-basic .social {
            text-align: center;
            padding-bottom: 25px;
        }

        .footer-basic .social > a {
            font-size: 24px;
            width: 40px;
            height: 40px;
            line-height: 40px;
            display: inline-block;
            text-align: center;
            border-radius: 50%;
            border: 1px solid #ccc;
            margin: 0 8px;
            color: inherit;
            opacity: 0.75;
        }

        .footer-basic .social > a:hover {
            opacity: 0.9;
        }

        .footer-basic .copyright {
            margin-top: 15px;
            text-align: center;
            font-size: 13px;
            color: #aaa;
            margin-bottom: 0;
        }


    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row bg-white shadow-sm">
        <div class="col-md-12">
            <div class="float-right py-4">
                @if (Route::has('login'))
                    <div class="links">
                        @auth
                            <a href="{{ route('create') }}">{{ __('Create Room') }}</a>
                            <a href="{{ route('dashboard') }}">{{ __('Account') }}</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}">Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row mt-5 mb-3">
        <div class="container ">
            <div class="row">
                <div class="col-md-3 mb-5"></div>
                <form class="col-md-6 mb-4" method="post" action={{route('home')}}>
                    @csrf
                    <div class="row d-flex justify-content-around align-items-center">
                        @foreach($filters as $filter)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="{{$filter['id']}}"
                                       id="{{$filter['filter']}}"
                                       name="{{$filter['filter']}}" {{$filter['checked'] ? 'checked' : null}}>
                                <label class="form-check-label" for="{{$filter['filter']}}">
                                    {{$filter['filter']}}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group row mt-5">
                        <label for="city"
                               class="col-md-3 col-form-label text-md-right">{{ __('Select a city') }}</label>
                        <div class="col-md-9">
                            <select class="form-control" id="city" name="city">
                                @foreach($cities as $city)
                                    <option value="{{$city['id']}}" {{$city['city'] === 'Amman' ? 'selected' : null}}>
                                        {{$city['city']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input class="btn btn-success" type="submit" value="Find a Room roomie!">
                        </div>
                    </div>
                </form>
            </div>
            <hr/>
        </div>
    </div>
    <div class="row mt-4">
        @foreach($available_rooms as $room)
            <div class="col-md-3 d-flex justify-content-center">
                <div class="card" style="width: 23rem;">
                    <img src='{{asset("Images/$room->img_path")}}' class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{$room->city}}</h5>
                        <p class="card-text">{{$room->description}}</p>
                        <a href="{{route('view', $room->id)}}" class="btn btn-primary">View room</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="footer-basic">
                <footer>
                    <ul class="list-inline">
{{--                        <li class="list-inline-item"><a href="{{route('home')}}">Home</a></li>--}}
                        <li class="list-inline-item"><a href="#">Services</a></li>
                        <li class="list-inline-item"><a href="#">About</a></li>
                        <li class="list-inline-item"><a href="#">Terms</a></li>
                        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                    </ul>
                    <p class="copyright">Roomie © 2019</p>
                </footer>
            </div>
        </div>
    </div>
</div>
</body>
</html>
