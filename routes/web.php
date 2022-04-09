<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
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
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function(){

    Route::resource('todo', TodoController::class)->except('index');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::get('/users/trashed', [DashboardController::class, 'userTrashed'])->name('admin.user.trashed');
    Route::get('/todos', [DashboardController::class, 'todos'])->name('todos');
    Route::put('/todo/{todo}', [DashboardController::class, 'todoEdit'])->name('todo.status');
    Route::get('/todo/{todo}', [DashboardController::class, 'showTodo'])->name('admin.todo.show');
    Route::get('/todos/trashed', [DashboardController::class, 'todoTrashed'])->name('admin.todo.trashed');
    Route::get('/todos/completed', [DashboardController::class, 'completed'])->name('admin.todo.completed');
    Route::get('/todos/uncompleted', [DashboardController::class, 'uncompleted'])->name('admin.todo.uncompleted');

});

Route::get('todo', [TodoController::class, 'index'])->name('todo.index');

require __DIR__.'/auth.php';
