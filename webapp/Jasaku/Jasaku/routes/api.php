<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\JasaController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('jasa', [JasaController::class, 'index']);
Route::get('jasa/{id}', [JasaController::class, 'show']);
Route::post('jasa', [JasaController::class, 'store']);
Route::put('/jasa/{id}', [JasaController::class, 'update']);
Route::delete('/jasa/{id}', [JasaController::class, 'destroy']);

Route::post('/login', [APIUserController::class, 'postLogin'])->name('login');