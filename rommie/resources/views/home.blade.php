@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-2" style="background-color: whitesmoke">
                <form class="mt-5 pb-5 pt-5 mb-5" method="post" action={{route('home',1)}}>
                    @csrf
                    @foreach($filters as $filter)
                        <div class="row mt-3 ml-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$filter['id']}}"
                                       id="{{$filter['filter']}}"
                                       name="{{$filter['filter']}}"
                                       {{$filter['checked'] ? 'checked' : null}} onchange="submit()">
                                <label class="form-check-label" for="{{$filter['filter']}}">
                                    {{$filter['filter']}}
                                </label>
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group row mt-5">
                        <label for="city"
                               class="col-md-5 col-form-label text-md-left">{{ __('Select a city') }}</label>
                        <div class="col-md-7">
                            <select class="form-control" id="city" name="city" onchange="submit()">
                                @foreach($cities as $city)
                                    <option value="{{$city['id']}}" {{$city['checked'] ? 'selected' : null}}>
                                        {{$city['city']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-9">
                <div class="row">
                    @if(!empty($available_rooms))
                        @foreach($available_rooms as $room)
                            <div class="col-md-4 d-flex justify-content-center mb-4">
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
                    @else
                        <div class="col-md-8 d-flex justify-content-center">
                            <h3>There are no rooms matching your criteria...</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
