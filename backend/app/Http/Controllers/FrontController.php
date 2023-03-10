<?php

namespace App\Http\Controllers;

use App\Models\BogiType;
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

    // get bogi types
    $bogi_types_with_seats = array();

    $bogi_types = BogiType::get();
    foreach ($bogi_types as $item) {
      $bogi_types_with_seats[] = [
        'id' => $item->id,
        'bogi_type_name' => $item->bogi_type_name,
        'total_seats' => 0
      ];
    }

    foreach ($results as $result) {
      // get seat range
      foreach ($result->seat_ranges as $item) {
        $bogi_type = $item->bogi->bogi_type->bogi_type_name;
        $seat_ranges = explode(',', $item->seats_range);

        // calculate total seats
        $start_seat = explode('-', $seat_ranges[0])[1];
        $end_seat = explode('-', $seat_ranges[1])[1];
        $seat_count = $end_seat - $start_seat + 1;

        for ($i = 0; $i < count($bogi_types_with_seats); $i++) {
          if ($bogi_types_with_seats[$i]['bogi_type_name'] == $bogi_type) {
            $bogi_types_with_seats[$i]['total_seats'] += $seat_count;
          }
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
        'seats' => $bogi_types_with_seats
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
