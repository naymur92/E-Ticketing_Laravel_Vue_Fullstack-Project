<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\TrainList;
use Illuminate\Http\Request;

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
    $data = array();

    foreach ($train_lists as $root_train) {
      $route_lists = $root_train->routes->sortBy('sl_no');

      $data[] = [
        'id' => $root_train->id,
        'train_name' => $root_train->train_name,
        'from_station' => $route_lists->first()->station->name,
        'to_station' => $route_lists->last()->station->name,
        'total_time' => $root_train->routes->excelToDateTimeObject('time_from_prev_station'),
      ];
    }
    return response()->json($data);
    // return view('pages.routes.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
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
}
