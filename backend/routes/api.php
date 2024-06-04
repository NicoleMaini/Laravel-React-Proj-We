<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SlotController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ActivityController;

// tutte le rotte scritte qui avranno middlewere diverse da quelle in route per blade
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// per visualizzare i valori delle route bisogna inserire dopo localhost la dicitura /api/

// Route::get('/hello', function () {
//     return 'funzia!';
// });

Route::name('api.v1.')
    ->prefix('v1') // un perfisso, che serve per tenere conto delle versioni che si useranno all'oggiornarsi della api
    ->group(function () {
        Route::get('/activities', [ActivityController::class, 'index']);
        Route::get('/activities/{id}', [ActivityController::class, 'show']);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::resource('/slots', SlotController::class);
            Route::resource('/courses', CourseController::class);
            Route::get('/costumer-dashboard', [CustomerController::class, 'customerDashboard']);
            Route::put('/costumer-dashboard-requiered/{id}', [CustomerController::class, 'customerRequired']);
            Route::put('/costumer-dashboard-cancel/{id}', [CustomerController::class, 'customerCancel']);
            Route::get('/admin-dashboard', [AdminController::class, 'adminDashboard']);
            Route::put('/admin-dashboard-accept/customer{customer_id}/course{course_id}', [AdminController::class, 'adminAccept']);
            Route::put('/admin-dashboard-reject/customer{customer_id}/course{course_id}', [AdminController::class, 'adminReject']);
        });
    });
