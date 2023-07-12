<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

//Route group including all routes, it uses the prevent-back-history middleware
Route::group(['middleware' => 'prevent-back-history'],function(){

    //Default Route
    Route::get('/', function() {

        if(Auth::check() == true){
            request()->session()->regenerate();

            return redirect('customer-list');
        }
        return view('login');    
    });




    //Route to login with credentials
    Route::post('/', 'App\Http\Controllers\LoginController@loginFunction')->name('userLogin');




    //Default Logout Route
    Route::get('/logout', function() {
        if(session()->has('userEmail')){
            session()->forget(['userID', 'userEmail', 'userName', 'userType']);
            Auth::logout();
        }
        return redirect('/');    
    });




    //Route to get customer_list view
    Route::get('customer-list',  'App\Http\Controllers\CustomerListController@index');

    //Route to get zones by states for customer's add/edit
    Route::post('customer-list/index-zones',  'App\Http\Controllers\CustomerListController@indexZonesByState')->name('getZones');

    //Route to get sellers by zone for customer's add/edit
    Route::post('customer-list/index-sellers',  'App\Http\Controllers\CustomerListController@indexSellersByZone')->name('getSellers');

    //Route to post the new customer info
    Route::post('customer-list/store', 'App\Http\Controllers\CustomerListController@store')->name('createCustomer');

    //Route to put any customer's info
    Route::put('customer-list/update', 'App\Http\Controllers\CustomerListController@update')->name('updateCustomer');
    
    //Route to delete a customer
    Route::delete('customer-list/delete', 'App\Http\Controllers\CustomerListController@delete')->name('deleteCustomer');




    //Route to get category_list view
    Route::get('category-list',  'App\Http\Controllers\CategoryListController@index');

    //Route to post the new customer info
    Route::post('category-list/store', 'App\Http\Controllers\CategoryListController@store')->name('createCategory');

    //Route to put any customer's info
    Route::put('category-list/update', 'App\Http\Controllers\CategoryListController@update')->name('updateCategory');
    
    //Route to delete a customer
    Route::delete('category-list/delete', 'App\Http\Controllers\CategoryListController@delete')->name('deleteCategory');




    //Route to get status_list view
    Route::get('status-list',  'App\Http\Controllers\StatusListController@index');

    //Route to post the new customer info
    Route::post('status-list/store', 'App\Http\Controllers\StatusListController@store')->name('createStatus');

    //Route to put any customer's info
    Route::put('status-list/update', 'App\Http\Controllers\StatusListController@update')->name('updateStatus');
    
    //Route to delete a customer
    Route::delete('status-list/delete', 'App\Http\Controllers\StatusListController@delete')->name('deleteStatus');




     //Route to get the user_list view
     Route::get('user-list', 'App\Http\Controllers\UserController@index');

     //Route to post the new user info
     Route::post('user-list/store', 'App\Http\Controllers\UserController@store')->name('createUser');
 
     //Route to post the update user info
     Route::put('user-list/update', 'App\Http\Controllers\UserController@update')->name('updateUser');
 
     //Route to post the delete user info
     Route::delete('user-list/delete', 'App\Http\Controllers\UserController@delete')->name('deleteUser');




     //Route to get the seller_list view
     Route::get('seller-list', 'App\Http\Controllers\SellerController@index');




     //Route to get the zone_list view
     Route::get('zone-list', 'App\Http\Controllers\ZoneController@index');

     //Route to post the new zone info
     Route::post('zone-list/store', 'App\Http\Controllers\ZoneController@store')->name('createZone');
 
     //Route to post the update zone info
     Route::put('zone-list/update', 'App\Http\Controllers\ZoneController@update')->name('updateZone');
 
     //Route to post the delete zone info
     Route::delete('zone-list/delete', 'App\Http\Controllers\ZoneController@delete')->name('deleteZone');




     //Route to get state_list view
     Route::get('state-list',  'App\Http\Controllers\StateListController@index');
 
     //Route to post the new customer info
     Route::post('state-list/store', 'App\Http\Controllers\StateListController@store')->name('createState');
 
     //Route to put any customer's info
     Route::put('state-list/update', 'App\Http\Controllers\StateListController@update')->name('updateState');
     
     //Route to delete a customer
     Route::delete('state-list/delete', 'App\Http\Controllers\StateListController@delete')->name('deleteState');

});
