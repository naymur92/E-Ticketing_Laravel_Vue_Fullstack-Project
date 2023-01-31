<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\Train;
use Illuminate\Http\Request;

class TicketController extends Controller
{
  public function check(Request $request)
  {
    $request->validate([
      'from' => 'required|integer',
      'to' => 'required|integer',
      'doj' => 'required'
    ]);

    $data = [];

    // search train on that specific date
    $trains = Train::where('date', $request->doj)->get();

    // search if that train has schedule on requested station
    foreach ($trains as $train) {
      $schedule = Schedule::where('station_id', $request->to)->where('train_id', $train->id)->first();

      if (!empty($schedule)) {
        // has schedule

        $available_type = [];
        $seatsAvailable = Seat::where('train_id', $train->id)->where('booked', 0)->get();
        foreach ($seatsAvailable as $seatAvailable) {
          $available_type[] = $seatAvailable->type;
        }
        $unique_available_type = array_unique($available_type);

        $available = [];
        foreach ($unique_available_type as $type) {
          $seatsTypeAvailable = Seat::where('train_id', $train->id)->where('booked', 0)->where('type', $type)->get();

          $available[] = [
            'type' => $type,
            'quantity' => count($seatsTypeAvailable),
            'fare' => ''
          ];
        }

        $data[] = [
          'train_name' => $train->name,
          'train_route' => 'test route',
          'dep_time' => date('F j, Y', strtotime($train->date)) . ' - ' . date('H:i:a', strtotime($schedule->time)),
          'seats_available' => '',
          'available' => $available
        ];
      }
    }

    // If found display data
    // $data = [
    //   'train_name' => '',
    //   'train_route' => '',
    //   'dep_time' => '',
    //   'seats_available' => '',
    //   'available' => [
    //     [
    //       'type' => '',
    //       'quantity' => '',
    //       'fare' => ''
    //     ]
    //   ],
    // ];


    return response()->json($data);
  }
}
