<?php

use App\Http\Controllers\Admin\MbaController;
use App\Http\Controllers\Admin\ProjectApplicationController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\MbaPhotoController;
use Illuminate\Support\Facades\Route;

//acces with api/admin

// mba
Route::prefix('mba')->group(function () {
    Route::get('all',  [MbaController::class, 'getAllMbas']);
    Route::get('active',  [MbaController::class, 'getActiveMbas']);
    Route::get('/{id}/show',  [MbaController::class, 'show']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('create',  [MbaController::class, 'create']);
        Route::post('update',  [MbaController::class, 'update']);
        Route::post('attach-media',  [MbaPhotoController::class, 'attachMedia']);
        Route::post('remove-media',  [MbaPhotoController::class, 'detachMedia']);
        Route::delete('/{id}/delete',  [MbaController::class, 'delete']);
    });
});


Route::middleware(['auth:sanctum'])->group(function () {

    // users
    Route::prefix('users')->group(function () {
        Route::get('all',  [UsersController::class, 'all']);
        Route::post('create',  [UsersController::class, 'create']);
        Route::post('update',  [UsersController::class, 'update']);
        Route::delete('/{id}/delete',  [UsersController::class, 'delete']);
        Route::get('/{id}/show',  [UsersController::class, 'show']);
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
});
