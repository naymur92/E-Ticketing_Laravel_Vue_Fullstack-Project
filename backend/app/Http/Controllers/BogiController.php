<?php

namespace App\Http\Controllers;

use App\Models\Bogi;
use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BogiController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
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
      'bogi_name' => 'required',
      'total_seats' => 'required|integer|min:15',
    ]);
    $bogi = new Bogi();
    $bogi->name = strtoupper($request->bogi_name);
    $bogi->train_id = $request->train_id;

    $bogi->save();

    // $bogi_id = DB::table('bogis')->insertGetId($request->only('name', 'train_id'));
    for ($i = 1; $i <= $request->total_seats; $i++) {
      DB::table('seats')->insert([
        'name' => strtoupper($request->bogi_name) . '-' . $i,
        'bogi_id' => $bogi->id,
        'train_id' => $request->train_id,
        'type' => 0,
        'booked' => rand(0, 1),
      ]);
    }

    flash()->addSuccess('Bogi and seat added');
    return back();
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
  public function edit($id)
  {
    //
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
  public function destroy($id)
  {
    $bogi = Bogi::findOrFail($id);
    // $bogi->seats()->delete();
    $bogi->delete();
    return back()->with('msg', 'Successfully Deleted');
  }
}
