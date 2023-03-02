<?php

namespace App\Http\Controllers;

use App\Models\Bogi;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\SeatRange;
use App\Models\Train;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $schedules = Schedule::get();

    return view('pages.schedules.index', compact('schedules'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.schedules.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $train_id = $request->train_id;
    $base_station = json_decode(json_encode($request->base_station), FALSE);
    $dest_stations = json_decode(json_encode($request->dest_stations), FALSE);

    foreach ($dest_stations as $dest_station) {
      $schedule = new Schedule();

      $schedule->train_id = $train_id;
      $schedule->from_station_id = $base_station->from_station_id;
      $schedule->to_station_id = $dest_station->to_station_id;
      $schedule->left_station_at = $base_station->left_station_at;
      $schedule->reach_destination_at = $dest_station->reach_at;
      $schedule->ac_b_price = $dest_station->ac_b_price;
      $schedule->ac_s_price = $dest_station->ac_s_price;
      $schedule->snigdha_price = $dest_station->snigdha_price;
      $schedule->f_berth_price = $dest_station->f_berth_price;
      $schedule->f_seat_price = $dest_station->f_seat_price;
      $schedule->f_chair_price = $dest_station->f_chair_price;
      $schedule->s_chair_price = $dest_station->s_chair_price;
      $schedule->shovon_price = $dest_station->shovon_price;

      $schedule->save();

      // Add seat ranges
      foreach ($dest_station->seat_ranges as $item) {
        $seat_range = new SeatRange();

        $seat_range->schedule_id = $schedule->id;
        $seat_range->bogi_id = $item->bogi_id->code;
        $seat_range->seats_range = $item->seat_start . ',' . $item->seat_end;

        $seat_range->save();
      }
    }


    flash()->addSuccess('Schedules & Seat Ranges Added');
    // return redirect(route('schedules.index'));
    return response()->json(['success' => true, 'msg' => 'Schedules Added']);
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

  // generate train list for add schedules
  public function trains_for_schedules()
  {
    $trains = Train::orderBy('journey_date', 'desc')->get();

    $data = array();
    foreach ($trains as $train) {
      // check train have schedules
      if (count($train->schedules) == 0) {
        $data[] = [
          'code' => $train->id,
          'label' => $train->name . ' - ' . $train->journey_date
        ];
      }
    }

    return response()->json($data);
  }

  // get route list for schedules
  public function route_list_for_schedules($id)
  {
    $train = Train::find($id);

    $route_list = $train->route->routes->sortBy('sl_no');
    // return $route_list;

    $first_route_item = $route_list->first();

    // extract first station data
    $base_station = [
      'from_station_id' => $first_route_item->station_id,
      'from_station_name' => $first_route_item->station->name,
      'left_station_at' => date('Y-m-d H:i:s', strtotime($train->journey_date)),
    ];

    $dest_stations = array();

    $reach_time = $train->journey_date;

    // extract other lists
    foreach ($route_list as $route) {
      // skip first item
      if ($route->sl_no == 1) {
        continue;
      }

      $time_hour = explode(':', $route->time_from_prev_station)[0];
      $time_min = explode(':', $route->time_from_prev_station)[1];

      $reach_time = date('Y-m-d H:i:s', strtotime("+{$time_hour} hour +{$time_min} minutes", strtotime($reach_time)));

      $dest_stations[] = [
        'to_station_id' => $route->station_id,
        'to_station_name' => $route->station->name,
        'reach_at' => $reach_time,
        'ac_b_price' => null,
        'ac_s_price' => null,
        'snigdha_price' => null,
        'f_berth_price' => null,
        'f_seat_price' => null,
        'f_chair_price' => null,
        's_chair_price' => null,
        'shovon_price' => null,
        'seat_ranges' => [
          [
            'bogi_id' => null,
            'seat_start' => null,
            'seat_end' => null,
          ]
        ]
      ];
    }

    return response()->json(['base_station' => $base_station, 'dest_stations' => $dest_stations]);
  }

  public function get_bogis($id)
  {
    $train = Train::findOrFail($id);
    $bogis = $train->bogis;
    $data = array();

    foreach ($bogis as $bogi) {
      $data[] = [
        'code' => $bogi->id,
        'label' => $bogi->bogi_name . ' (' . $bogi->bogi_type->bogi_type_name . ')'
      ];
    }

    return response()->json($data);
  }

  public function get_seats($id)
  {
    $seats = Seat::where('bogi_id', $id)->get();
    $data = array();

    foreach ($seats as $seat) {
      $data[] = $seat->seat_name;
    }

    return response()->json($data);
  }
}
