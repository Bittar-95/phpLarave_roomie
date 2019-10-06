<?php

namespace App\Http\Controllers;

use App\City;
use App\Filter;
use App\Image;
use App\Room;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function index(Request $requests)
    {
        DB::update("update filters set checked=false");
        DB::update("update cities set checked=false");

        //to get the condition to view the rooms and to check filters
        $params = $requests->request;
        $length = count($params);
        $filters=" filter_id = ";
        $count = 2;
        foreach ($params as $filter=>$id){
            if($filter === 'city'){
                DB::update("update cities set checked=true where id=$id");
            }
            if($filter !== '_token' and $filter !== 'city'){
                if($count<$length) {
                    DB::update("update filters set checked=true where id=$id");
                    $filters = $filters.$id." or filter_id = ";
                    $count++;
                    continue;
                } else {
                    DB::update("update filters set checked=true where id=$id");
                    $filters = $filters.$id;
                }
            }
            $count++;
        }
        if($length === 2) {
            $filters = null;
        }

        //viewing rooms
        if($filters !== null){
            $rooms_id = DB::select("SELECT relation.room_id,rooms.city_id FROM relation,rooms where relation.room_id = rooms.id and rooms.city_id = ".$requests->input('city')." and $filters");
            $where_room_id = " and rooms.id = ";
            $length_room_id = count($rooms_id);
            $count =1;

            foreach ($rooms_id as $room_id)
            {
                $room_identification = $room_id->room_id;
                $where_room_id .= $room_identification;
                if($count <$length_room_id) {
                    $where_room_id.=" or rooms.id = ";
                }
                $count++;
            }
            if($length_room_id===0)
            {
                $where_room_id = null;
            }
        } else {
            $where_room_id=null;
        }

            $filters = Filter::all();
            $cities= City::all();
            $get_rooms = null;

            if($requests->input('city') !== null){
                $get_rooms = DB::select("select rooms.id,rooms.description,rooms.rent,cities.city,images.img_path from cities inner join rooms on rooms.city_id = cities.id inner join images on images.room_id = rooms.id where cities.id = ".$requests->input('city').$where_room_id);
            }

            return view("home",["filters"=>$filters,"available_rooms"=>$get_rooms,"cities"=>$cities]);
    }

    public function view($room_id)
    {
        $room_data = Room::find($room_id);
        $city = City::find($room_data->city_id);
        $owner = User::find($room_data->user_id);
        $image = Image::find($room_id);
        $filters =DB::select("select filters.filter from relation left outer join filters on filters.id = relation.filter_id where relation.room_id = $room_id");

        return view("view", ['room_data' => $room_data, 'city' => $city, 'owner' => $owner, 'image' => $image,  'filters' => $filters]);
    }
}
