<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

// Common Resources Routes :
// (CRUD)
//
// index   - show all listings
// show    - show single listings
// create  - show form to create new listing
// store   - store new listing
// edit    - show form to edit listing
// update  - update listing
// destroy - Delete listing

// all job listings
Route::get('/', [ListingController::class, 'index']);

// show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store job
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// show edit form
Route::get('/listings/{job}/edit', [ListingController::class, 'edit'])->middleware('auth');

// update job
Route::put('/listings/{job}', [ListingController::class, 'update'])->middleware('auth');

// delete job
Route::delete('/listings/{job}', [ListingController::class, 'destroy'])->middleware('auth');

// manage listing
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// single job
Route::get('/listings/{job}', [ListingController::class, 'show']);

// show register / creat form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// create new user
Route::post('/users', [UserController::class, 'store']);

// log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');;

// authenticate user
Route::post('users/authenticate', [UserController::class, 'authenticate']);

