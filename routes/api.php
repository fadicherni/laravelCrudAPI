<?php

use App\Http\Controllers\PetController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'],  function () {
        Route::get('/pet/findByStatus', [PetController::class, 'findPetByStatus']);
        Route::get('/pets', [PetController::class, 'index']);
        Route::get('/pet/{petId}', [PetController::class, 'show']);
        Route::post('/pet', [PetController::class, 'store']);
        Route::post('/pet/{petId}/uploadImage', [PetController::class, 'uploadImage']);
        Route::put('/pet', [PetController::class, 'update']);
        Route::post('/pet/{petId}', [PetController::class, 'updatePet']);
        Route::delete('/pet/{petId}', [PetController::class, 'destroy']);
    }
);
