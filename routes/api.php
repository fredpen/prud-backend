<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserDetailsController;



// others
Route::group(['prefix' => 'misc'], function () {
    Route::get('banks',  [UserDetailsController::class, 'getBanks']);
});

// auth
Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'signup'])->name('register');
    Route::post('reset-passowrd',  [AuthController::class, 'resetPassword']);
    Route::post('initiate-password-reset',  [AuthController::class, 'initiatePasswordReset']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('logout',  [AuthController::class, 'logout']);
    });
});

// user
Route::group(['prefix' => 'user'], function () {

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('details',  [UserController::class, 'userDetails']);
        Route::post('update-user', [UserController::class, 'updateUser']);
        Route::post('update-security-data', [UserController::class, 'updateSecurityData']);
        Route::post('set-user-security', [UserController::class, 'setSecurity']);

        Route::post('update-details', [UserDetailsController::class, 'update']);
    });
});

// notification
Route::group(['prefix' => 'notifications', 'middleware' => 'auth:sanctum'], function () {

    Route::get('all', [NotificationController::class, 'all']);
    Route::get('unread', [NotificationController::class, 'unread']);
    Route::post('delete', [NotificationController::class, 'delete']);
    Route::post('mark-as-read', [NotificationController::class, 'markAsRead']);
});

// payments
Route::group(['prefix' => 'project/payment'], function () {

    Route::get('verify', [PaymentController::class, 'verify']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::middleware(['isAdmin'])->group(function () {
            Route::get('all_transactions', [PaymentController::class, 'index']);
            Route::get('successful_transactions', [PaymentController::class, 'succesfulTransactions']);
        });

        Route::middleware(['projectAdminRight'])->group(function () {
            Route::get('initiate', [PaymentController::class, 'initiate']);
            Route::get('my-transactions', [PaymentController::class, 'userPayments']);
            Route::get('my-successful-transactions', [PaymentController::class, 'userSuccesfulPayments']);
        });
    });
});


