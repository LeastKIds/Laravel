<?php

use App\Http\Controllers\PostsController;
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

require __DIR__.'/auth.php';


Route::prefix('/posts') -> group(function () {

    Route::get('/create', [PostsController::class, 'create']); //-> middleware(['auth']);
    Route::post('/store', [PostsController::class, 'store']); //-> middleware(['auth']);
    Route::get('/index', [PostsController::class, 'index']) ->name('posts.index');
    Route::get('/show/{id}', [PostsController::class, 'show']) -> name('post.show');

    Route::get('/{post}', [PostsController::class, 'edit']) -> name('post.edit');
    Route::put('/{id}', [PostsController::class, 'update']) -> name('post.update');
    Route::delete('/{id}', [PostsController::class, 'delete']) -> name('post.delete');
});

