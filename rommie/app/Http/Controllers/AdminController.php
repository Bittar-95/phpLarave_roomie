<?php

namespace App\Http\Controllers;

use App\Filter;
use App\Image;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\City;

class AdminController extends Controller
{
    public function index($id = null, $name = null, Request $request)
    {
        return "Hello $id $name" . $request->input('name');
    }

    public function create()
    {
        $filters = Filter::all();
        $cities = City::all();
        return view("create", ["filters" => $filters, "cities" => $cities]);
    }

    public function add(Request $request)
    {
        $image = $request->file('img_path');
        $new_name = rand() . "." . $image->getClientOriginalExtension();
        $image->move(public_path("/Images"), $new_name);

        $desc = $request->input('description');
        $rent = $request->input('rent');
        $city_id = $request->input('city');
        $user_id = auth()->id();
        DB::insert("insert into rooms (description,rent,user_id,city_id) Values ('$desc','$rent',$user_id,$city_id);");
        $room_id = DB::select("SELECT LAST_INSERT_ID() as last_room_id");
        $last_room_id = $room_id[0]->last_room_id;

        $img = new Image();
        $img->img_path = $new_name;
        $img->room_id = $last_room_id;
        $img->save();

        $filters = Filter::all("filter");
        foreach ($filters as $filter) {
            $filter_id = $request->input($filter->filter);
            if (isset($filter_id)) {
                DB::insert("insert into relation values($last_room_id,$filter_id)");
            }
        }

        return redirect()->action('AdminController@dashboard');
    }

    public function dashboard()
    {
        $rooms = DB::select("select rooms.id,images.img_path,rooms.user_id,rooms.description,rooms.rent,cities.city from rooms left outer join images on images.room_id = rooms.id inner join cities on rooms.city_id = cities.id where rooms.user_id = " . \auth()->id());

        return view("dashboard", ["rooms_data" => $rooms]);
    }

    public function edit($room_id)
    {
        DB::update("update filters set checked=false");
        $cities = City::all();
        $room = DB::select("select rooms.id,images.img_path,rooms.user_id,rooms.description,rooms.rent,cities.city from rooms left outer join images on images.room_id = rooms.id inner join cities on rooms.city_id = cities.id where rooms.id = $room_id");
        $filters = Filter::all();

        return view("edit", ["room_info" => $room, "cities" => $cities, "filters" => $filters]);
    }

    public function update(Request $request, $room_id)
    {
        $desc = $request->input('description');
        $rent = $request->input('rent');
        $city_id = $request->input('city');
        DB::update("update rooms set description = '$desc', rent = $rent, city_id = $city_id where id=$room_id");

        if($request->input('img_path') !== null) {
            $image = $request->file('img_path');
            $new_name = rand() . "." . $image->getClientOriginalExtension();
            $image->move(public_path("/Images"), $new_name);
            DB::update("update images set img_path = '$new_name' where room_id = $room_id");
        }
        DB::delete("delete from relation where room_id = $room_id");

        $filters = Filter::all("filter");
        foreach ($filters as $filter) {
            $filter_id = $request->input($filter->filter);
            if (isset($filter_id)) {
                DB::insert("insert into relation values($room_id,$filter_id)");
            }
        }

        return redirect()->action('AdminController@dashboard');
    }

    public function profile()
    {
        $cities = City::all();

        return view("profile", ['user'=> \auth()->user(),"cities"=>$cities]);
    }



    public function update_profile(Request $request)
    {
        $first = $request->input('first_name');
        $last = $request->input('last_name');
        $city = $request->input('city');
        $mobile = $request->input('mobile_number');
        DB::update("update users set first_name = '$first', last_name = '$last', city_id = $city, mobile_number = $mobile where id = ".auth()->id());

        return redirect()->action('AdminController@dashboard');
    }

    public function remove($id){
        DB::delete("delete from rooms where id = $id");
        return redirect()->action('AdminController@dashboard');
    }

    public function tools(){
        return view('tools');
    }

    public function add_tools(Request $request){
        $filter = $request->input('filter');
        $city = $request->input('city');

        DB::insert("insert into filters (filter) values ('$filter')");
        DB::insert("insert into cities (city) values ('$city')");

        return redirect()->action('AdminController@dashboard');
    }

}
