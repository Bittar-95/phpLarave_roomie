<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\City;
use App\Filter;
use Illuminate\Support\Facades\DB;

Route::match(['get','post'],'/', function () {
    $filters= Filter::all();
    $rooms = DB::select("select rooms.id, rooms.description,rooms.rent,cities.city,images.img_path from cities inner join rooms on rooms.city_id = cities.id inner join images on rooms.id = images.room_id LIMIT 4");
    $cities= City::all();
    return view('welcome',["filters"=>$filters,"available_rooms"=>$rooms,"cities"=>$cities]);
});

Auth::routes();
Route::any('/home/{id?}', 'GuestController@index')->name('home');
Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
Route::get('/tools', 'AdminController@tools')->name('tools');
Route::any('/add_tools', 'AdminController@add_tools')->name('add_tools');
Route::view('/profile', 'profile')->name('profile');
Route::get('/view/{room_id}', 'GuestController@view')->name('view');
Route::any('/create', 'AdminController@create')->name('create');
Route::any('/add', 'AdminController@add')->name('add');
Route::any('/edit/{id}', 'AdminController@edit')->name('edit');
Route::any('/update/{id}', 'AdminController@update')->name('update');
Route::any('/profile', 'AdminController@profile')->name('profile');
Route::any('/update_profile', 'AdminController@update_profile')->name('update_profile');
Route::get('remove/{id}','AdminController@remove')->name('remove');


