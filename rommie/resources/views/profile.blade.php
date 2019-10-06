@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <form method="post" action="{{route('update_profile')}}">
            @csrf
            <div class="form-group mt-4">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                       value="{{$user->first_name}}"/>
            </div>

            <div class="form-group mt-4">
                <label for="last_name">Monthly Rent in JOD</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{$user->last_name}}"/>
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
                <label for="mobile_number">Monthly Rent in JOD</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                       value="{{$user->mobile_number}}"/>
            </div>

            <input type="submit" class="btn btn-primary mt-4" value="Create Room"/>
        </form>
    </div>
@endsection
