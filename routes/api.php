<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KidController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


require __DIR__.'/auth.php';




Route::group(['middleware'=>'jwt.verify'],function (){

    ////routes for doctor
    Route::group(['middleware'=>'doctorCheck','prefix'=>'doctor'],function (){

        Route::get('/kid/{id}',[\App\Http\Controllers\Api\DoctorController::class,'get']);
        Route::get('/kids',[\App\Http\Controllers\Api\DoctorController::class,'allKids']);
        Route::post('/search',[\App\Http\Controllers\Api\DoctorController::class,'search']);
        Route::post('/add',[\App\Http\Controllers\Api\DoctorController::class,'addKid']);
        Route::post('/update/{kid}',[\App\Http\Controllers\Api\DoctorController::class,'updateKid']);
        Route::post('/updateMedicalHistory/{kid}',[\App\Http\Controllers\Api\DoctorController::class,'updateMedicalHistory']);
        Route::get('/medicalHistory/{kid}',[\App\Http\Controllers\Api\DoctorController::class,'medicalHistory']);
        Route::post('/getMedicalHistory',[\App\Http\Controllers\Api\DoctorController::class,'searchMedicalHistory']);

    });


    ///routes for police
    Route::group(['middleware'=>'policeCheck','prefix'=>'police'],function (){

        Route::post('/search',[\App\Http\Controllers\Api\PoliceController::class,'search']);

    });

    ///routes for police
    Route::group(['middleware'=>'adminCheck','prefix'=>'admin'],function (){

        Route::post('/createAccount',[\App\Http\Controllers\Api\AdminController::class,'createAccount']);

    });
});

Route::get('/zz', function () {
    return 500;
});
