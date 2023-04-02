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
    $schedules = json_decode(json_encode($request->schedules), FALSE);


    foreach ($schedules as $schedule) {
      $base_station = $schedule->base_station;
      $dest_stations = $schedule->dest_stations;

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
          // if seat range not selected then skip
          if ($item->seat_start == null || $item->seat_end == null) continue;

          $seat_range = new SeatRange();

          $seat_range->schedule_id = $schedule->id;
          $seat_range->bogi_id = $item->bogi_id;
          $seat_range->seats_range = $item->seat_start . ',' . $item->seat_end;

          $seat_range->save();
        }
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
    $schedule = Schedule::findOrFail($id);
    $schedule->delete();

    flash()->addSuccess('Schedule Deleted Successfullly');

    return back();
  }

  // generate train list for add schedules
  public function trains_for_schedules()
  {
    $trains = Train::orderBy('journey_date', 'desc')->get();

    $data = array();
    foreach ($trains as $train) {
      // if train bogis is not available then skip
      if (count($train->bogis) == 0) continue;

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

    // get bogi_type_names
    $bogi_type_names = $train->bogis->pluck('bogi_type.bogi_type_name');

    // get schedules
    $schedules = array();

    $total_left_time_hour = 0;
    $total_left_time_min = 0;

    $route_list = $train->route->routes->sortBy('sl_no');
    for ($i = 0; $i < count($route_list) - 1; $i++) {
      $first_route_item = $route_list[$i];

      // calculate left time
      $total_left_time_hour += explode(':', $route_list[$i]->time_from_prev_station)[0];
      $total_left_time_min += explode(':', $route_list[$i]->time_from_prev_station)[1];

      $left_time = date('Y-m-d H:i:s', strtotime("+{$total_left_time_hour} hour +{$total_left_time_min} minutes", strtotime($train->journey_date)));

      // extract first station data
      $base_station = [
        'from_station_id' => $first_route_item->station_id,
        'from_station_name' => $first_route_item->station->name,
        'left_station_at' => $left_time,
      ];

      // get bogis and seats
      $bogis = $train->bogis;
      $bogis_seats = array();
      if (count($bogis) == 0) {
        $bogis_seats['bogis'] = [];
        $bogis_seats['seats'] = [];
      }

      foreach ($bogis as $bogi) {
        $bogis_seats['bogis'][] = [
          'code' => $bogi->id,
          'label' => $bogi->bogi_name . ' (' . $bogi->bogi_type->bogi_type_name . ')'
        ];
        $bogis_seats['seats'][] = $bogi->seats->pluck('seat_name');
      }

      $dest_stations = array();

      $time_hour = 0;
      $time_min = 0;
      // extract other lists
      for ($j = $i + 1; $j < count($route_list); $j++) {
        // calculate reach time
        $time_hour += explode(':', $route_list[$j]->time_from_prev_station)[0];
        $time_min += explode(':', $route_list[$j]->time_from_prev_station)[1];

        $reach_time = date('Y-m-d H:i:s', strtotime("+{$time_hour} hour +{$time_min} minutes", strtotime($left_time)));

        // get last price list
        $last_schedule = Schedule::where('from_station_id', $first_route_item->station_id)->where('to_station_id', $route_list[$j]->station_id)->orderBy('created_at', 'desc')->first();

        // get seat_ranges
        $seat_ranges = array();
        foreach ($bogis_seats['bogis'] as $key => $bogi) {
          $seat_ranges[] = [
            'bogi_id' => $bogi['code'],
            'bogi_name' => $bogi['label'],
            'seat_start' => null,
            'seat_end' => null,
          ];
        }

        $dest_stations[] = [
          'to_station_id' => $route_list[$j]->station_id,
          'to_station_name' => $route_list[$j]->station->name,
          'reach_at' => $reach_time,
          'ac_b_price' => $last_schedule->ac_b_price ?? null,
          'ac_s_price' => $last_schedule->ac_s_price ?? null,
          'snigdha_price' => $last_schedule->snigdha_price ?? null,
          'f_berth_price' => $last_schedule->f_berth_price ?? null,
          'f_seat_price' => $last_schedule->f_seat_price ?? null,
          'f_chair_price' => $last_schedule->f_chair_price ?? null,
          's_chair_price' => $last_schedule->s_chair_price ?? null,
          'shovon_price' => $last_schedule->shovon_price ?? null,
          'seat_ranges' => $seat_ranges,
        ];
      }
      $schedules[] = [
        'base_station' => $base_station,
        'dest_stations' => $dest_stations,
      ];
    }

    return response()->json(['schedules' => $schedules, 'bogi_types' => $bogi_type_names, 'bogis_seats' => $bogis_seats]);
  }
}
