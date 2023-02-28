<?php

namespace App\Http\Controllers;

use App\Models\BogiType;
use Illuminate\Http\Request;

class BogiTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $bogi_types = BogiType::orderBy('created_at', 'desc')->get();
    return view('pages.bogi-types.index', compact('bogi_types'));
  }

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
      'bogi_type_name' => 'required|unique:bogi_types',
      'seat_count' => 'required|integer|max:123|min:20'
    ]);

    $bogi_type = new BogiType();
    $bogi_type->bogi_type_name = $request->bogi_type_name;
    $bogi_type->seat_count = $request->seat_count;

    $bogi_type->save();

    flash()->addSuccess('Bogi Type Added');
    return redirect(route('bogi-types.index'));
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
    $bogi_type = BogiType::findOrFail($id);
    $bogi_type->delete();

    flash()->addSuccess('Bogi Type Deleted');
    return redirect(route('bogi-types.index'));
  }
}
