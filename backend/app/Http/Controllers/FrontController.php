<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use DateTime;
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
      // get bogi types
      $bogi_types = array();
      foreach ($result->train->bogis as $bogi) {
        $bogi_types[] = $bogi->bogi_type->bogi_type_name;
      }

      // foreach ($result->train->bogis as $bogi) {
      //   $bogi_types[] = [
      //     'id' => $bogi->bogi_type->id,
      //     'bogi_type_name' => $bogi->bogi_type->bogi_type_name
      //   ];
      // }

      // get seat range
      $bogis_seats = array();
      foreach ($result->seat_ranges as $item) {
        $bogi_type = $item->bogi->bogi_type->bogi_type_name;
        $seat_ranges = explode(',', $item->seats_range);
        $start = $seat_ranges[0];
        $end = $seat_ranges[1];
        $bogi_id = $item->bogi_id;

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

      // calculate total time
      $start_time = new DateTime($result->left_station_at);
      $total_time = $start_time->diff(new DateTime($result->reach_destination_at));

      $data[] = [
        'id' => $result->id,
        'train_name' => $result->train->name,
        'from' => $result->from_station->name,
        'to' => $result->to_station->name,
        'left_at' => date('d M, Y - h:i a', strtotime($result->left_station_at)),
        'reach_at' => date('d M, Y - h:i a', strtotime($result->reach_destination_at)),
        'total_time' => $total_time->h . ' Hours : ' . $total_time->i . ' Minutes',
        'seats' => $bogis_seats
      ];
    }

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
