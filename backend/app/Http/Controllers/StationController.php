<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
  public function listStations()
  {
    return response()->json(Station::get(), status: 200);
  }
}
