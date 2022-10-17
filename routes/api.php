<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('get_records', [MainController::class, 'getRecords']);
Route::post('save_records', [MainController::class, 'saveRecords']);
Route::delete('reset_records', [MainController::class, 'resetRecords']);
Route::post('main', [MainController::class, 'login']);



