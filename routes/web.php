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
Route::get('/offender_ages', [ChartController::class, 'offender_ages']);
Route::get('/offense_vs_location', [ChartController::class, 'offense_vs_location']);

Route::get('/offense_type_vs_weapon_type_dbscan', [ClusteringController::class, 'offense_type_vs_weapon_type_dbscan']);
Route::get('/offense_type_vs_weapon_type_kmeans', [ClusteringController::class, 'offense_type_vs_weapon_type_kmeans']);
Route::get('/offender_ages_vs_offense_type_dbscan', [ClusteringController::class, 'offender_ages_vs_offense_type_dbscan']);
Route::get('/offender_ages_vs_offense_type_kmeans', [ClusteringController::class, 'offender_ages_vs_offense_type_kmeans']);
