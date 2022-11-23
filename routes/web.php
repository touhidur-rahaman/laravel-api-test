<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// common routing practices
//  index - show all 
// show - show single item
// create - show creating form 
// store - store item 
// edit - show edit form 
// update - update item 
// destroy - delete item 

Route::get('/', [ListingController::class, 'index']);

// show create form 
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store data 
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show Edit Form 
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Edit Submit to Update 
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete item 
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

Route::get('/listings/{listing}', [ListingController::class, 'show']);

// show register form 
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// create new users
Route::post('/users', [UserController::class, 'store']);

// log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// show login form
Route::get('/logins', [UserController::class, 'login'])->name('login')->middleware('auth');

// Log in user 
Route::post('/users/authenticate', [UserController::class, 'authenticate']);