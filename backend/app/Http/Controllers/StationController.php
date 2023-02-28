<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $stations = Station::get();
    return view('pages.stations.index', compact('stations'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.stations.create');
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
      'address' => 'required|min:3',
      'lat' => 'required|numeric',
      'lon' => 'required|numeric',
    ]);

    $station = new Station();
    $station->name = $request->name;
    $station->address = $request->address;
    $station->lat = $request->lat;
    $station->lon = $request->lon;

    $station->save();
    flash()->addSuccess('Station Added');
    // return redirect(route('stations.index'));
    return response()->json(['success' => true, 'msg' => 'Station Added']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $station = Station::findOrFail($id);
    return view('pages.stations.show', compact('station'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $station = Station::findOrFail($id);
    return view('pages.stations.edit', compact('station'));
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
      'address' => 'required|min:3',
      'lat' => 'required|numeric',
      'lon' => 'required|numeric',
    ]);

    $station = Station::findOrFail($id);
    $station->name = $request->name;
    $station->address = $request->address;
    $station->lat = $request->lat;
    $station->lon = $request->lon;

    $station->update();
    flash()->addSuccess('Station Updated');
    return redirect(route('stations.index'));
    // return response()->json(['success' => true, 'msg' => 'Station Added']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $station = Station::findOrFail($id);
    $station->delete();

    flash()->addSuccess('Successfully Deleted');
    return redirect(route('stations.index'));
    // return response()->json(['success' => true, 'msg' => 'Station Added']);

  }

  // this data is for add component
  public function listStations()
  {
    $stations = Station::get();

    $data = [];

    foreach ($stations as $station) {
      $data[] = [
        'label' => $station->name,
        'code' => $station->id
      ];
    }
    return response()->json($data, status: 200);
  }
}
