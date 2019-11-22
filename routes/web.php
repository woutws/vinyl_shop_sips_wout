<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');

// });

/*Route::get('contact-us', function () {
    //return 'Contact info';
    return view("contact");
});*/
Route::view('contact-us', 'contact');
Route::view('/', 'home');

/*Route::get('admin/records', function (){
    $records = [
        'Queen - Greatest Hits',
        'The Rolling Stones - Sticky Fingers',
        'The Beatles - Abbey Road'
    ];
    return view('admin.records.index',  [
        "records" => $records]);

});*/

//shop routes
Route::get('shop', 'ShopController@index');
Route::get('shop/{id}', 'ShopController@show');
Route::get('shop_alt', 'ShopController@alt');


// New version with prefix and group
Route::prefix('admin')->group(function () {
    Route:: redirect("/", "admin/records");
    Route::get('records', 'Admin\RecordController@index');
});
