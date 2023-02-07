<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Train;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;

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
    $stations = Station::get();

    return view('pages.trains.create', compact('stations'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, FlasherInterface $flasher)
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
    $flasher->addSuccess('Train Added');
    return redirect(route('trains.index'));
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id, FlasherInterface $flasher)
  {
    $train = Train::findOrFail($id);
    $train->delete();
    $flasher->addWarning('Train Deleted');
    return back();
  }
}
