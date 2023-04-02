<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
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
    $users = User::select('id', 'name', 'email', 'phone', 'is_admin', 'created_at')->orderBy('created_at', 'desc')->get();
    return view('pages.users.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.users.create');
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
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'phone' => ['required', 'numeric', 'unique:users'],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'is_admin' => ['required']
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'phone' => $request->phone,
      'password' => Hash::make($request->password),
      'is_admin' => $request->is_admin
    ]);

    if ($user) {
      flash()->addSuccess('User Added');

      return redirect(route('users.index'));
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $user = User::findOrFail($id);
    return view('pages.users.show', compact('user'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = User::findOrFail($id);

    if ($user->is_admin == 'admin') {
      flash()->addError('Admin Cannot be Edit!');
      return redirect(route('users.index'));
    }

    return view('pages.users.edit', compact('user'));
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
    $user = User::findOrFail($id);

    if ($user->is_admin == 'admin') {
      flash()->addError('Admin Cannot be Edit!');
      return redirect(route('users.index'));
    }

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
      'phone' => ['required', 'numeric', 'unique:users,phone,' . $id],
      'is_admin' => ['required']
    ]);

    $user->update($request->only('name', 'email', 'phone', 'is_admin'));

    flash()->addSuccess('User Updated');

    // return back();
    return redirect(route('users.index'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);

    if ($user->is_admin == 'admin') {
      flash()->addError('Admin Cannot be Delete!');
      return redirect(route('users.index'));
    }

    $user->delete();

    flash()->addSuccess('User Deleted');

    return redirect(route('users.index'));
  }
}
