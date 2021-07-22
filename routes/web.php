<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\testController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/posts/index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/register', function () {
    return view('/auth/register');
}) -> name('register');

require __DIR__.'/auth.php';


Route::prefix('/posts') -> group(function () {

    Route::get('/myPosts', [PostsController::class, 'myPosts']) -> name('posts.myPosts');
    Route::get('/create', [PostsController::class, 'create']); //-> middleware(['auth']);
    Route::post('/store', [PostsController::class, 'store']); //-> middleware(['auth']);
    Route::get('/index', [PostsController::class, 'index']) ->name('posts.index');


    Route::get('/show/{id}', [PostsController::class, 'show']) -> name('post.show');

//    이 아래로는 쓰면 안됨. 무조건 먹힘
    Route::get('/{post}', [PostsController::class, 'edit']) -> name('post.edit');
    Route::put('/{id}', [PostsController::class, 'update']) -> name('post.update');
    Route::delete('/{id}', [PostsController::class, 'destroy']) -> name('post.delete');


});

Route::prefix('/chart') -> group(function () {
    Route::get('/index', [ChartController::class, 'index']);
});


Route::prefix('/test') -> group(function () {
    Route::get('/get', [testController::class, 'get']);
    Route::get('/login/error', [testController::class, 'loginError']) -> name('test.loginError');
});

