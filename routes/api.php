<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LableController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\WebServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::middleware('auth:sanctum')->group(function () {
    // todolist routes start //

    Route::apiResource('todo-list', TodoController::class);

    /* Route::get('todo-list', [TodoController::class, 'index'])
        ->name('todo-list.index');
    
    Route::get('todo-list/{todo_list}', [TodoController::class, 'show'])
        ->name('todo-list.show');
    
    Route::post('todo-list', [TodoController::class, 'store'])
        ->name('todo-list.store');
    
    Route::delete('todo-list/{todo_list}', [TodoController::class, 'destroy'])
        ->name('todo-list.destroy');
    Route::patch('todo-list/{todo_list}', [TodoController::class, 'update'])
        ->name('todo-list.update'); */

    // todolist routes end //

    // task routes start //

    Route::apiResource('todo-list.task', TaskController::class)
        ->except('show')
        ->shallow();
    /* Route::get('task', [TaskController::class, 'index'])
        ->name('task.index');
        Route::post('task', [TaskController::class, 'store'])
        ->name('task.store');
        Route::delete('task/{task}', [TaskController::class, 'destroy'])
        ->name('task.destroy'); */

    // task routes end //

    Route::apiResource('lable', LableController::class);
    Route::get('service/connect/{service_name}', [WebServiceController::class, 'connect'])->name('service.connect');
    Route::post('service/callback', [WebServiceController::class, 'callback'])->name('service.callback');
    Route::post('service/{service_name}', [WebServiceController::class, 'store'])->name('service.store');
});


Route::post('register', RegisterController::class)->name('user.register');
Route::post('login', LoginController::class)->name('user.login');
