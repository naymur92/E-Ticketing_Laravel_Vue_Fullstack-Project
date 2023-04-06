<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Seat;
use DateTime;
use Illuminate\Http\Request;

class BookingController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function get_booking_details($id)
  {
    $schedule = Schedule::where('id', $id)->with('train', 'train.bogis', 'train.bogis.bogi_type')->get();

    return response()->json($schedule);
  }

  public function get_seats_by_bogis($id)
  {
    $seats = Seat::where('bogi_id', $id)->get();
    return response()->json($seats);
  }

  public function get_train_details($id)
  {
    $result = Schedule::findOrFail($id);
    $data = array();

    // get bogi types
    $bogi_types_with_seats = array();
    $bogi_types = $result->train->bogis->pluck('bogi_type.bogi_type_name');
    foreach ($bogi_types as $b_type) {
      $bogi_types_with_seats[$b_type] = 0;
    }

    $seat_ranges = array();

    // get seat range
    foreach ($result->seat_ranges as $item) {
      $bogi_type = $item->bogi->bogi_type->bogi_type_name;
      $seats_range = explode(',', $item->seats_range);

      // calculate total seats
      $start_seat = intval(explode('-', $seats_range[0])[1]);
      $end_seat = intval(explode('-', $seats_range[1])[1]);

      // count available seats
      $seat_count = 0;
      foreach ($item->bogi->seats as $seat) {
        $seat_sl_no = intval(explode('-', $seat)[1]);
        if ($seat_sl_no >= $start_seat && $seat_sl_no <= $end_seat && $seat->booked == 0) {
          $seat_count++;
        }
      }

      // $seat_count = $end_seat - $start_seat + 1;

      $seat_ranges[explode('-', $seats_range[0])[0]] = [
        'start_seat' => $start_seat,
        'end_seat' => $end_seat
      ];

      $bogi_types_with_seats[$bogi_type] += $seat_count;
    }

    // calculate total time
    $start_time = new DateTime($result->left_station_at);
    $total_time = $start_time->diff(new DateTime($result->reach_destination_at));

    $data[] = [
      'train_details' => [
        'id' => $result->id,
        'train_name' => $result->train->name,
        'from' => $result->from_station->name,
        'to' => $result->to_station->name,
        'left_at' => date('d M, Y - h:i a', strtotime($result->left_station_at)),
        'reach_at' => date('d M, Y - h:i a', strtotime($result->reach_destination_at)),
        'total_time' => $total_time->h . ' Hours : ' . $total_time->i . ' Minutes',
      ],
      'available_seats' => $bogi_types_with_seats,
      'price_details' => [
        'ac_b_price' => $result->ac_b_price ?? 0,
        'ac_s_price' => $result->ac_s_price ?? 0,
        'snigdha_price' => $result->snigdha_price ?? 0,
        'f_berth_price' => $result->f_berth_price ?? 0,
        'f_seat_price' => $result->f_seat_price ?? 0,
        'f_chair_price' => $result->f_chair_price ?? 0,
        's_chair_price' => $result->s_chair_price ?? 0,
        'shovon_price' => $result->shovon_price ?? 0,
      ],
      'seat_ranges' => $seat_ranges
    ];

    return response()->json($data);
  }

  public function book_seat($id)
  {
    return response()->json(['success' => true]);
  }
}
