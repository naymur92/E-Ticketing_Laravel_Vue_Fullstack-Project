<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BogiController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TrainListController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [FrontController::class, 'home'])->name('home');
Route::post('/check', [FrontController::class, 'check']);

Route::middleware(['auth'])->group(function () {
  Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

  Route::resource('users', UserController::class);
  Route::resource('stations', StationController::class);
  Route::resource('trainlists', TrainListController::class);
  Route::resource('trains', TrainController::class);

  Route::post('bogis', [BogiController::class, 'store'])->name('bogis.store');
  Route::delete('bogis/{bogi}', [BogiController::class, 'destroy'])->name('bogis.destroy');
});
Route::get('list-stations', [StationController::class, 'listStations']);

require __DIR__ . '/auth.php';

Route::any('{slug}', function () {
  return view('home');
});
