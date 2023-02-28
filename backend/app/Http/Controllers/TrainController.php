<?php

namespace App\Http\Controllers;

use App\Models\Bogi;
use App\Models\BogiType;
use App\Models\Seat;
use App\Models\Station;
use App\Models\Train;
use App\Models\TrainList;
use Illuminate\Http\Request;
// use Flasher\Prime\FlasherInterface;

class TrainController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $trains = Train::orderBy('journey_date', 'desc')->get();
    return view('pages.trains.index', compact('trains'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.trains.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|min:3',
      'journey_date' => 'required',
      'journey_time' => 'required',
      'route_id' => 'required|integer',
    ]);

    // check valid date and time
    if (time() >= strtotime($request->journey_date . ' ' . $request->journey_time) || time() >= strtotime($request->start_date . ' ' . $request->journey_time) || time() >= strtotime($request->end_date . ' ' . $request->journey_time)) {
      return response()->json(['success' => false, 'msg' => 'Please Select correct Date']);
    }

    if ($request->start_date == '' || $request->end_date == '') {
      $journey_date = $request->journey_date . ' ' . $request->journey_time;

      $train = new Train();
      $train->name = $request->name;
      $train->journey_date = $journey_date;
      $train->route_id = $request->route_id;

      $train->save();

      // call bogi add method
      foreach ($request->bogis as $bogi) {
        $bogi_type_id = $bogi['bogi_type_id']['code'];

        if ($bogi_type_id > 0 && $bogi['bogi_name'] != '') {
          $this->add_bogi_seat($train->id, $bogi_type_id, $bogi['bogi_name']);
        }
      }
    } else {
      // count total days
      $num_days = round((strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24));

      $cur_date = $request->start_date;
      for ($i = 1; $i <= $num_days; $i++) {
        // check off day and skip
        if (date('w', strtotime($cur_date)) == $request->off_day) {
          $cur_date = date('Y-m-d', strtotime($cur_date . ' +1 day'));
          continue;
        }

        // generate date-time
        $journey_date = $cur_date . ' ' . $request->journey_time;

        $train = new Train();
        $train->name = $request->name;
        $train->journey_date = $journey_date;
        $train->route_id = $request->route_id;

        $train->save();

        // call bogi add method
        foreach ($request->bogis as $bogi) {
          $bogi_type_id = $bogi['bogi_type_id']['code'];

          if ($bogi_type_id > 0 && $bogi['bogi_name'] != '') {
            $this->add_bogi_seat($train->id, $bogi_type_id, $bogi['bogi_name']);
          }
        }

        $cur_date = date('Y-m-d', strtotime($cur_date . ' +1 day'));
      }
    }

    flash()->addSuccess('Train, Bogis and Seats Added');
    // return redirect(route('trains.index'));
    return response()->json(['success' => true, 'msg' => 'Train Added']);
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
  public function edit(Train $train)
  {
    // $stations = Station::get();
    return view('pages.trains.edit', compact('train'));
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
    $request->validate([
      'name' => 'required|min:3',
      'date' => 'required|date',
      'home_station_id' => 'required|integer',
      'start_time' => 'required',
    ]);

    $train = Train::findOrFail($id);

    if ($train->update($request->only('name', 'date', 'home_station_id', 'start_time'))) {
      flash()->addSuccess('Train Updated');
      return redirect(route('trains.index'));
    } else {
      flash()->addError('Somthing went wrong! Try again!');
      return back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $train = Train::findOrFail($id);
    $train->delete();
    flash()->addWarning('Train Deleted');
    return back();
  }

  // data for add train
  public function listRootTrains()
  {
    $root_trains = TrainList::get();
    $up_down = ['UP', 'DOWN'];

    $data = array();
    foreach ($root_trains as $root_train) {
      // check root_train has routes
      if (count($root_train->routes) > 0) {
        $data[] = [
          'code' => $root_train->id,
          'label' => $root_train->train_name . ' - ' . $up_down[$root_train->up_down],
        ];
      }
    }

    return response()->json($data);
  }

  // When select root train then generate another data
  public function rootTrainData($id)
  {
    $train_data = TrainList::findOrFail($id);

    $day_to_number = [
      'Sunday' => 0,
      'Monday' => 1,
      'Tuesday' => 2,
      'Wednesday' => 3,
      'Thursday' => 4,
      'Friday' => 5,
      'Saturday' => 6,
    ];

    // generate data
    $data = [
      'train_name' => $train_data->train_name,
      'off_day' => $day_to_number["$train_data->off_day"]
    ];

    return response()->json($data);
  }

  // get bogi_info
  public function bogiTypes()
  {
    $bogi_types = BogiType::get();

    $data = array();
    foreach ($bogi_types as $type) {
      $data[] = [
        'code' => $type->id,
        'label' => $type->bogi_type_name,
      ];
    }

    return response()->json($data);
  }

  // bogi add function
  public function add_bogi_seat($train_id, $bogi_type_id, $bogi_name)
  {
    $bogi = new Bogi();

    $bogi->bogi_name = strtoupper($bogi_name);
    $bogi->train_id = $train_id;
    $bogi->bogi_type_id = $bogi_type_id;

    $bogi->save();

    for ($i = 1; $i <= $bogi->bogi_type->seat_count; $i++) {
      $seat = new Seat();
      $seat->seat_name = $bogi->bogi_name . '-' . $i;
      $seat->bogi_id = $bogi->id;
      $seat->booked = 0;

      $seat->save();
    }
  }
}
