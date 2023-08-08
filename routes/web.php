<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
});



// Route::post('/', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/', [ProductController::class, 'home']);
Route::get('/detail/{id}', [ProductController::class, 'detail']);
Route::get('/profile/{id}', [ProductController::class, 'profile']);
Route::get('/userProfile/{id}', [ProductController::class, 'userProfile']);


Route::get('/search', [ProductController::class, 'search']);
Route::get('/searchFriend', [ProductController::class, 'searchFriends']);

Route::get("/cartlist",[ProductController::class,'cartList']); 
Route::get('/cart', [ProductController::class, 'cart']);
Route::get("removecart/{id}",[ProductController::class,'removeCart']);
Route::get("removefriend/{id}",[ProductController::class,'removefriend']);
Route::get("removebookmark/{id}",[ProductController::class,'removebookmark']);


Route::post('/add_to_cart', [ProductController::class, 'Addcart']);
Route::post('/add_to_bookmark', [ProductController::class, 'Addbookmark']);

Route::post('/addfriend', [ProductController::class, 'Addfriend']);

Route::get('/friends', [ProductController::class, 'friends']);
Route::get("/bookmark",[ProductController::class,'bookmark']); 






// Route::get('/home', [ProductController::class, 'home']);


// Route::match(['GET', 'POST'], '/', [UserController::class, 'login']);




