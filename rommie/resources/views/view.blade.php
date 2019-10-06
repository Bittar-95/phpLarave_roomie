@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <img class="img-thumbnail" src="{{asset("/Images/$image->img_path")}}"/>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3">Contact details</h3>
                                <p class="card-text">{{$owner->first_name." ".$owner->last_name}}</p>
                                <p class="card-text">{{$owner->email}}</p>
                                <p class="card-text">{{$owner->mobile_number}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3">Room description</h3>
                                <p class="card-text">{{$room_data->description}}</p>
                                <p class="card-text"><b>Rent per month </b>{{$room_data->rent." JOD"}}</p>
                                <p class="card-text"><b>{{$city->city."-Jordan"}}</b></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="mb-3">Allowed</h3>
                                <ul>
                                    @foreach($filters as $filter)
                                        <li class="card-text">{{$filter->filter}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
