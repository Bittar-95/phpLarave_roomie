@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row mt-5 d-flex">
            <div class="col-md-12">
                <form class="float-right" method="get" action="{{route('create')}}">
                    @csrf
                    <input class="btn btn-primary" type="submit" value="Create Room"/>
                </form>
                @if(auth()->id() === 1)
                    <form class="float-right mr-2" method="get" action="{{route('tools')}}">
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Admin Tools"/>
                    </form>
                @endif
            </div>
        </div>
        @foreach($rooms_data as $room_data)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <img src="{{asset("Images/$room_data->img_path")}}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{$room_data->city}}</h5>
                            <p class="card-text">{{$room_data->description}}</p>
                            <div class="d-flex">
                                <form action="{{route('edit',$room_data->id)}}">
                                    @csrf
                                    <input type="submit" class="btn btn-primary mr-3" name="edit" id="edit"
                                           value="Edit"/>
                                </form>
                                <form action="{{route('remove',$room_data->id)}}">
                                    @csrf
                                    <input type="submit" class="btn btn-danger" name="remove" id="remove"
                                           value="REMOVE"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
