<?php
use App\Units;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::resource('masterlist', 'MasterListController');
Route::resource('recipes', 'RecipeController');

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('testing', function(){
    $i=1;
    $testing = array();
    while($i < 17){
        $test = Math::GetApSmallUnit($i);
        $first = Units::find($i);
        $second = Units::find($test);
        $testing[$first->name] = $second->name;
        $i++;
    }
    return view('testing')->withTesting($testing);
});
