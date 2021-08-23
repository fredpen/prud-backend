<?php

use App\Http\Controllers\Admin\ProjectApplicationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

//acces with api/admin

// users
Route::prefix('users')->group(function () {
    Route::get('all',  [UsersController::class, 'all']);
    Route::post('create',  [UsersController::class, 'create']);
    Route::post('update',  [UsersController::class, 'update']);
});


// Projects
Route::prefix('project')->group(function () {
    Route::get('drafts',  [ProjectController::class, 'drafts']);
    Route::get('published',  [ProjectController::class, 'published']);
    Route::get('started',  [ProjectController::class, 'started']);
    Route::get('completed',  [ProjectController::class, 'completed']);
    Route::get('cancelled',  [ProjectController::class, 'cancelled']);
    Route::get('deleted',  [ProjectController::class, 'deleted']);
    Route::get('user/{user_id}',  [ProjectController::class, 'usersProject']);
});

// users
Route::prefix('users')->group(function () {
    Route::get('all',  [UsersController::class, 'all']);
});

// Projects applications
Route::prefix('project-application')->group(function () {
    Route::post('assign',  [ProjectApplicationController::class, 'assign']);
    Route::post('withdraw_assignment',  [ProjectApplicationController::class, 'withdraw']);
});

