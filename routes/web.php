<?php
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
})->name('home');
Route::resource('invoices', 'InvoiceController');
Route::resource('invoices.records', 'InvoiceRecordController');

Route::resource('masterlist', 'MasterListController');
Route::resource('masterlist.conversions', 'ConversionController');
Route::resource('masterlist.statistics', 'MasterListStatisticsController');

Route::resource('profile', 'UserProfileController');

Route::put('recipes/{recipeId}/instructions', 'RecipeController@instructions')
    ->name('recipes.instructions');
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
