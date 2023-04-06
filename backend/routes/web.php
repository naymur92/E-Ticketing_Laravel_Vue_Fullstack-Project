<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BogiController;
use App\Http\Controllers\BogiTypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ScheduleController;
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

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->group(function () {
  Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

  // Resource paths
  Route::resource('users', UserController::class);
  Route::resource('stations', StationController::class);
  Route::resource('train-lists', TrainListController::class);
  Route::resource('routes', RouteController::class);
  Route::resource('bogi-types', BogiTypeController::class);
  Route::resource('trains', TrainController::class);
  Route::resource('schedules', ScheduleController::class);

  Route::post('bogis', [BogiController::class, 'store'])->name('bogis.store');
  Route::delete('bogis/{bogi}', [BogiController::class, 'destroy'])->name('bogis.destroy');

  // route for generate data for vue components
  Route::get('list-stations', [StationController::class, 'listStations']);

  Route::get('root-stations', [RouteController::class, 'root_stations']);

  Route::get('root-trains', [TrainController::class, 'listRootTrains']);
  Route::get('root-train/{id}', [TrainController::class, 'rootTrainData']);
  Route::get('bogi-types-list', [TrainController::class, 'bogiTypes']);

  Route::get('trains-for-schedules', [ScheduleController::class, 'trains_for_schedules']);
  Route::get('route-list/{train_id}', [ScheduleController::class, 'route_list_for_schedules']);
});

// ticket checking
Route::get('/from-stations', [FrontController::class, 'from_stations']);
Route::get('/to-stations/{id}', [FrontController::class, 'to_stations']);
Route::post('/search-train', [FrontController::class, 'check']);

Route::middleware(['auth', 'user-access:user'])->group(function () {
  // booking
  Route::get('/get-booking-details/{schedule_id}', [BookingController::class, 'get_booking_details']);
  Route::get('get-seats/{id}', [BookingController::class, 'get_seats_by_bogis']);
  Route::get('get-train-details-for-booking/{id}', [BookingController::class, 'get_train_details']);
});


Route::any('{slug}', function () {
  return view('home');
})->where('slug', '.*');
