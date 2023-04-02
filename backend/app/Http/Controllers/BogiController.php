<?php

namespace App\Http\Controllers;

use App\Models\Bogi;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BogiController extends Controller
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
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  // public function index()
  // {
  //   //
  // }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  // public function create()
  // {
  //   //
  // }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'bogi_name' => 'required',
      'bogi_type_id' => 'required',
    ]);

    // if bogi_name is duplicate then end process
    $bogi_exists = Bogi::where('train_id', $request->train_id)->where('bogi_name', strtoupper($request->bogi_name))->get();
    if (count($bogi_exists) > 0) {
      flash()->addWarning('Duplicate Bogi Name for - ' . strtoupper($request->bogi_name) . '!');
      return back();
    }

    // add bogi
    $bogi = Bogi::create([
      'bogi_name' => strtoupper($request->bogi_name),
      'train_id' => $request->train_id,
      'bogi_type_id' => $request->bogi_type_id,
    ]);

    // add seats
    for ($i = 1; $i <= $bogi->bogi_type->seat_count; $i++) {
      DB::table('seats')->insert([
        'seat_name' => $bogi->bogi_name . '-' . $i,
        'bogi_id' => $bogi->id,
        'booked' => 0,
      ]);
    }

    flash()->addSuccess('Bogi and seats added');
    return back();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function show($id)
  // {
  //   //
  // }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function edit($id)
  // {
  //   //
  // }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  // public function update(Request $request, $id)
  // {
  //   //
  // }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $bogi = Bogi::findOrFail($id);
    // $bogi->seats()->delete();
    $bogi->delete();
    flash()->addSuccess('Bogi Deleted');
    return back();
  }
}
