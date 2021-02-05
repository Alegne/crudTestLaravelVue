<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonnelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listePerso/{q?}', [PersonnelController::class, 'index'] );
Route::delete('/listePerso/{id}', [PersonnelController::class, 'destroy'] );
Route::patch('/listePerso/{id}', [PersonnelController::class, 'update'] );
Route::post('/listePerso/', [PersonnelController::class, 'store'] );