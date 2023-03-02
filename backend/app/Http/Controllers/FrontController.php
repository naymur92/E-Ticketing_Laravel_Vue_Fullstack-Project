<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
  public function home()
  {
    return view('home');
  }

  public function check(Request $request)
  {
    $request->validate([
      'from' => 'required|integer',
      'to' => 'required|integer',
      'doj' => 'required'
    ]);

    $results = Schedule::where('from_station_id', $request->from)->where('to_station_id', $request->to)->whereDate('left_station_at', $request->doj)->get();

    $data = [];

    foreach ($results as $result) {
      // get bogy types
      $bogi_types = array();
      foreach ($result->train->bogis as $bogi) {
        $bogi_types[] = $bogi->bogi_type->bogi_type_name;
      }

      // get seat range
      $bogis_seats = array();
      foreach ($result->seat_ranges as $item) {
        $bogi_type = $item->bogi->bogi_type->bogi_type_name;
        $seat_ranges = explode(',', $item->seats_range);
        $start = $seat_ranges[0];
        $end = $seat_ranges[1];
        $bogi_id = $item->bogi_id;

        // $seats = Seat::where('bogi_id', $bogi_id)->where('booked', 0)->whereBetween('seat_name', [$start, $end])->count();

        $start_seat = explode('-', $seat_ranges[0])[1];
        $end_seat = explode('-', $seat_ranges[1])[1];
        $seat_count = $end_seat - $start_seat + 1;

        if (count($bogis_seats) != 0) {
          if (array_key_exists($bogi_type, $bogis_seats)) {
            $bogis_seats[$bogi_type] = $bogis_seats[$bogi_type] + $seat_count;
          } else {
            $bogis_seats[$bogi_type] = $seat_count;
          }
        } else {
          $bogis_seats[$bogi_type] = $seat_count;
        }
      }

      $data[] = [
        'id' => $result->id,
        'train_name' => $result->train->name,
        'from' => $result->from_station->name,
        'to' => $result->to_station->name,
        'left_at' => $result->left_station_at,
        'reach_at' => $result->reach_destination_at,
        'total_time' => date('h:i', (strtotime($result->reach_destination_at) - strtotime($result->left_station_at))),
        'seats' => $bogis_seats
      ];
    }

    // // search train on that specific date
    // $trains = Train::where('date', $request->doj)->get();

    // // search if that train has schedule on requested station
    // foreach ($trains as $train) {
    //   $schedule = Schedule::where('station_id', $request->to)->where('train_id', $train->id)->first();

    //   if (!empty($schedule)) {
    //     // has schedule

    //     $available_type = [];
    //     $seatsAvailable = Seat::where('train_id', $train->id)->where('booked', 0)->get();
    //     foreach ($seatsAvailable as $seatAvailable) {
    //       $available_type[] = $seatAvailable->type;
    //     }
    //     $unique_available_type = array_unique($available_type);

    //     $total_seats = 0;
    //     $available = [];
    //     foreach ($unique_available_type as $type) {
    //       $seatsTypeAvailable = Seat::where('train_id', $train->id)->where('booked', 0)->where('type', $type)->get();

    //       $seatTypeName = table_name_by_number()[$type];
    //       $available[] = [
    //         'type' => type_name_by_number()[$type],
    //         'quantity' => count($seatsTypeAvailable),
    //         'fare' => $schedule->$seatTypeName
    //       ];

    //       $total_seats += count($seatsTypeAvailable);
    //     }

    //     $data[] = [
    //       'train_name' => $train->name,
    //       'train_route' => 'test route',
    //       'dep_time' => date('F j, Y', strtotime($train->date)) . ' - ' . date('H:i:a', strtotime($schedule->time)),
    //       'seats_available' => $total_seats,
    //       'available' => $available
    //     ];
    //   }
    // }

    return response()->json($data);
  }

  public function get_auth()
  {
    return response()->json(Auth::user());
  }

  public function from_stations()
  {
    $stations = Station::get();
    $data = array();
    foreach ($stations as $station) {
      if (count($station->schedules) > 0) {
        $data[] = [
          'code' => $station->id,
          'label' => $station->name,
        ];
      }
    }

    return response()->json($data);
  }

  public function to_stations($id)
  {
    $to_station_ids = Schedule::where('from_station_id', $id)->select('to_station_id as id')->distinct()->get();

    $data = array();
    foreach ($to_station_ids as $id) {
      $station = Station::find($id->id);
      $data[] = [
        'label' => $station->name,
        'code' => $station->id
      ];
    }

    return response()->json($data);
  }
}
