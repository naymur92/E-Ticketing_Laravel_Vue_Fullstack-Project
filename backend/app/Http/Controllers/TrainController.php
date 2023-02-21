<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Train;
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
    $trains = Train::get();
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
      'date' => 'required|date',
      'home_station_id' => 'required|integer',
      'start_time' => 'required',
    ]);

    $train = new Train();
    $train->name = $request->name;
    $train->date = $request->date;
    $train->home_station_id = $request->home_station_id;
    $train->start_time = $request->start_time;

    $train->save();
    flash()->addSuccess('Train Added');
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
    $stations = Station::get();
    return view('pages.trains.edit', compact('train', 'stations'));
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
}
