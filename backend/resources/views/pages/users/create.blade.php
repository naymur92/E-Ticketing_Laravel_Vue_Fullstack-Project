@extends('layouts.app')

@section('title', 'Add User')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add User</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">User Adding Form</h5>
            <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Back</a>
          </div>

          <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">

              {{-- Name section --}}
              <div class="form-group">
                <label for="_name"><strong>Full Name:</strong></label>
                <input type="text" id="_name" name="name" value="{{ old('name') }}"
                  placeholder="Enter Full Name" class="form-control">

                @error('name')
                  <div class="alert alert-warning my-2">{{ $message }}</div>
                @enderror
              </div>

              {{-- Email section --}}
              <div class="form-group">
                <label for="_email"><strong>Email:</strong></label>
                <input type="email" id="_email" name="email" value="{{ old('email') }}" placeholder="Enter Email"
                  class="form-control">

                @error('email')
                  <div class="alert alert-warning my-2">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password section --}}
              <div class="row">
                <div class="col-6">
                  <label for="_pass"><strong>Password:</strong></label>
                  <input type="password" id="_pass" name="password" value="{{ old('password') }}"
                    placeholder="Enter Password" class="form-control">
                </div>
                <div class="col-6">
                  <label for="_pass_conf"><strong>Confirm Password:</strong></label>
                  <input type="password" id="_pass_conf" name="password_confirmation" placeholder="Retype Password"
                    class="form-control">
                </div>
                <div class="col-12">
                  @error('password')
                    <div class="alert alert-warning my-2">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Role section --}}
              <div class="form-group">
                <label for="_role"><strong>Select Role:</strong></label>
                <select name="is_admin" id="_role" class="form-control">
                  <option value="" selected disabled>Select One</option>
                  <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>User</option>
                  <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>Admin</option>
                </select>

                @error('is_admin')
                  <div class="alert alert-warning my-2">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <input type="submit" value="SUBMIT" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>
    </div>


  </div>
@endsection
