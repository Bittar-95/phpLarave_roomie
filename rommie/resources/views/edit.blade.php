@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <form method="post" action="{{route('update', $room_info[0]->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-4">
                <label for="description">Room Description</label>
                <textarea class="form-control" id="description" name="description"
                          rows="3">{{$room_info[0]->description}}</textarea>
            </div>

            <div class="form-group mt-4">
                <label for="rent">Monthly Rent in JOD</label>
                <input type="text" class="form-control" id="rent" name="rent" value="{{$room_info[0]->rent}}"/>
            </div>

            <div class="form-group mt-4">
                <label for="city">{{ __('Select a city') }}</label>
                <select class="form-control" id="city" name="city">
                    @foreach($cities as $city)
                        <option value="{{$city['id']}}" {{$city['city'] === 'Amman' ? 'selected' : null}}>
                            {{$city['city']}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-4">
                <input type="file" class="form-control-file mt-4" name="img_path"/>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <img class="img-thumbnail" src="{{URL::to('/')}}/Images/{{$room_info[0]->img_path}}"/>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
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

            <input type="submit" class="btn btn-primary" value="Update Room"/>
        </form>
    </div>
    </div>
@endsection
