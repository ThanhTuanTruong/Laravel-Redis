<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RedisController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redis;

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

// Route::get('/', function () {
//     // return view('welcome');

//     // print_r(app()->make('redis'));
// });

Route::get('/', [WelcomeController::class, 'index']);


Route::get('/redis', [RedisController::class, 'index']);

Route::get('/blog', [BlogController::class, 'index']);
Route::get('/article/{id}', [BlogController::class, 'showArticle'])->where('id', '[0-9]+');
Route::get('/filter/{tag}', [BlogController::class, 'showFilteredArticles']);

Route::get('/{id}/postupdate', [UserController::class, 'showAddUpdate'])->where('id', '[0-9]+');
Route::post('/{id}/postupdate', [UserController::class, 'doAddUpdate'])->where('id', '[0-9]+');
Route::get('/{id}/feed', [UserController::class, 'showFeed'])->where('id', '[0-9]+');

Route::get('/{id}/userlist', [UserController::class, 'showUserList'])->where('id', '[0-9]+');
Route::get('/{id}/following', [UserController::class, 'showFollowingList'])->where('id', '[0-9]+');
Route::get('/{id}/follow/{userID}', [UserController::class, 'followUser'])->where('id', '[0-9]+');
Route::get('/{id}/unfollow/{userID}', [UserController::class, 'unfollowUser'])->where('id', '[0-9]+');

Route::get('/admin/addarticle', [AdminController::class, 'showAddArticle']);
Route::post('/admin/addarticle', [AdminController::class, 'doAddArticle']);