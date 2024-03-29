<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\dataController;
use App\Http\Controllers\Api\V1\listController;
use App\Http\Controllers\Api\V1\listFinanceController;
use App\Http\Controllers\Api\V1\accController;
use App\Http\Controllers\Api\V1\subController;
use App\Http\Controllers\Api\V1\creditorController;
use App\Http\Controllers\Api\V1\CompleteTaskController;
use App\Http\Controllers\Api\V1\userController;
use App\Http\Controllers\Api\V1\financeViewController;
use App\Http\Controllers\Api\V1\permController;
use App\Http\Controllers\Api\V1\departmentController;
use App\Http\Controllers\Api\V1\budgetController;

Route::prefix('v1')->group(function () {
    Route::apiResource('/tasks', TaskController::class);
    Route::patch('/tasks/{task}/complete', CompleteTaskController::class);
    Route::apiResource('/data', dataController::class);
    Route::apiResource('/list', listController::class);
    Route::apiResource('/listFinance', listFinanceController::class);
    Route::apiResource('/acc_type', accController::class);
    Route::apiResource('/sub_type', subController::class);
    Route::apiResource('/creditor', creditorController::class);
    //Route::apiResource('/users', userController::class);
   // Route::get('/users', userController::class);
    Route::apiResource('/financeview', financeViewController::class);
    Route::apiResource('/permission', permController::class);
    Route::apiResource('/department', departmentController::class);
    Route::apiResource('/budget', budgetController::class);
});
