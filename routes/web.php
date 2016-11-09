<?php
use Auth;
use App\User;

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
Route::resource('masterlist.conversions', 'ConversionController');
Route::resource('masterlist.pricetracking', 'MasterListPriceTrackingController');

Route::resource('profile', 'UserProfileController');

Route::resource('recipes', 'RecipeController');
Route::resource('recipes.elements', 'RecipeElementController');

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('cloak/{userId}', function ($userId) {
    if (Auth::user()->id == '1'){
        $user = User::find($userId);
        if ($user) {
            Auth::login($user);
        }
    }
    return redirect('/');
});
