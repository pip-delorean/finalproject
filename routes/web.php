<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ClusteringController;

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

Route::get('/', [ChartController::class, 'index']);
Route::get('/dbscan', [ClusteringController::class, 'dbscan']);
Route::get('/incidents', [ChartController::class, 'incidents']);
Route::get('/offense_vs_location', [ChartController::class, 'offense_vs_location']);
Route::get('/offense_type_vs_weapon_type', [ChartController::class, 'offense_type_vs_weapon_type']);
