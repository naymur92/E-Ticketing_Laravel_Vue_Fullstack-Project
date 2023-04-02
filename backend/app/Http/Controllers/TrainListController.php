<?php

namespace App\Http\Controllers;

use App\Models\TrainList;
use Illuminate\Http\Request;

class TrainListController extends Controller
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
  public function index()
  {
    $train_lists = TrainList::orderBy('created_at', 'desc')->get();
    return view('pages.train-lists.index', compact('train_lists'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.train-lists.create');
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
      'train_name' => 'required|min:4',
      'off_day' => 'required',
      'up_down' => 'required'
    ]);

    // check duplicate data
    $root_train_exists = TrainList::where('train_name', $request->train_name)->where('up_down', $request->up_down)->get();
    if (count($root_train_exists) > 0) {
      flash()->addError('Duplicate Entry!');
      return back();
    }

    $root_train = [
      'train_name' => $request->train_name,
      'off_day' => $request->off_day,
      'up_down' => $request->up_down,
      'created_at' => date("Y-m-d H:i:s")
    ];

    TrainList::insert($root_train);

    flash()->addSuccess('Root Train Added Successfully');
    return redirect(route('train-lists.index'));
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
    $root_train = TrainList::findOrFail($id);
    return view('pages.train-lists.edit', compact('root_train'));
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
    $root_train = TrainList::findOrFail($id);

    $request->validate([
      'train_name' => 'required|min:4',
      'off_day' => 'required',
      'up_down' => 'required'
    ]);

    $root_train->update($request->only('train_name', 'off_day', 'up_down'));

    flash()->addSuccess('Root Train Updated Successfully');
    return redirect(route('train-lists.index'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $root_train = TrainList::findOrFail($id);

    $root_train->delete();

    flash()->addWarning('Root Train Deleted Successfully');
    return back();
  }
}
