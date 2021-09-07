<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\InvestmentsController;
use App\Http\Controllers\Admin\MbaController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\MbaBenefitsController;
use App\Http\Controllers\MbaPhotoController;
use App\Http\Controllers\MbaPlanController;
use App\Http\Controllers\WalletController;
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

        Route::prefix('benefits')->group(function () {
            Route::post('create',  [MbaBenefitsController::class, 'create']);
            Route::post('update',  [MbaBenefitsController::class, 'update']);
            Route::post('delete',  [MbaBenefitsController::class, 'delete']);
        });

        Route::prefix('plans')->group(function () {
            Route::post('create',  [MbaPlanController::class, 'create']);
            Route::post('update',  [MbaPlanController::class, 'update']);
            Route::post('delete',  [MbaPlanController::class, 'delete']);
        });
    });
});

Route::middleware(['auth:sanctum'])->group(function () {

    // investments
    Route::group(['prefix' => 'investments'], function () {

        Route::get('{id}/users', [InvestmentsController::class, 'usersInvestments']);
        Route::get('all', [InvestmentsController::class, 'allInvestments']);
        Route::post('create', [InvestmentsController::class, 'create']);
        Route::get('{id}/show', [InvestmentsController::class, 'show']);
        Route::get('{id}/show', [InvestmentsController::class, 'show']);
        Route::get('{id}/update', [InvestmentsController::class, 'update']);
    });


    // walltes
    Route::prefix('wallet')->group(function () {
        Route::post('debit',  [WalletController::class, 'debit']);
        Route::post('credit',  [WalletController::class, 'credit']);
    });

    Route::prefix('audits')->group(function () {
        Route::get('user/{id}',  [AuditController::class, 'userAudit']);
        Route::get('wallet/{id}',  [AuditController::class, 'walletAudit']);
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('all',  [UsersController::class, 'all']);
        Route::post('create',  [UsersController::class, 'create']);
        Route::post('update',  [UsersController::class, 'update']);
        Route::delete('/{id}/delete',  [UsersController::class, 'delete']);
        Route::get('/{id}/show',  [UsersController::class, 'show']);
    });
});
