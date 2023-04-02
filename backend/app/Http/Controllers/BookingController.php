<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
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
}
