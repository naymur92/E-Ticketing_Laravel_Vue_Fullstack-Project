<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Station;
use App\Models\TrainList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $routes = TrainList::with('routes', 'routes.station')->get();

    $train_lists = TrainList::get();
    $routes = array();

    foreach ($train_lists as $root_train) {
      $route_lists = $root_train->routes->sortBy('sl_no');
      $up_down = ['UP', "DOWN"];

      // Caclucate total time in sec
      $total_time = Route::where('route_id', $root_train->id)->sum(DB::raw("TIME_TO_SEC(time_from_prev_station)"));

      $routes[] = [
        'id' => $root_train->id,
        'train_name' => $root_train->train_name . ' - ' . $up_down[$root_train->up_down],
        'off_day' => $root_train->off_day,
        'from_station' => $route_lists->first()->station->name,
        'to_station' => $route_lists->last()->station->name,
        'total_time' => gmdate('H:i', $total_time),
      ];
    }
    // return response()->json($routes);
    return view('pages.train-routes.index', compact('routes'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.train-routes.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $route_id = $request['route_id']['code'];

    foreach ($request['routes'] as $route) {
      Route::create([
        'route_id' => $route_id,
        'station_id' => $route['station_id']['code'],
        'time_from_prev_station' => $route['time_from_prev_station'],
        'sl_no' => $route['sl_no'],
        'created_at' => time()
      ]);
    }
    flash()->addSuccess('Route Added Successfully');
    // return redirect(route('routes.index'));
    return response()->json(['success' => true]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function root_stations()
  {
    $stations = Station::get();
    $train_lists = TrainList::get();
    $up_down = ['UP', 'DOWN'];

    $data = array();

    foreach ($stations as $station) {
      $data['stations'][] = [
        'label' => $station->name,
        'code' => $station->id
      ];
    }

    foreach ($train_lists as $train) {
      $data['train_lists'][] = [
        'label' => $train->train_name . ' - ' . $up_down[$train->up_down],
        'code' => $train->id
      ];
    }

    return response()->json($data);
  }
}
