@extends('layouts.app')
@section('content')

    <div class="container mt-5">
        <form method="post" action="{{route('add_tools')}}">
            @csrf
            <div class="form-group mt-4">
                <label for="filter">Add filter</label>
                <input type="text" class="form-control" id="filter" name="filter" />
            </div>

            <div class="form-group mt-4">
                <label for="city">Add City</label>
                <input type="text" class="form-control" id="city" name="city"/>
            </div>

            <input type="submit" class="btn btn-primary mt-4" value="Add"/>
        </form>
    </div>

@endsection
