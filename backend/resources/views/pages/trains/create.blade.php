@extends('layouts.app')

@section('title', 'Add Train')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Train</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Train Adding Form</h5>
        <a href="{{ route('trains.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <form action="{{ route('trains.store') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="form-group my-2">
            <label for="_name"><strong>Train Name:</strong></label>
            <input type="text" name="name" value="{{ old('name') }}" id="_name" placeholder="Enter train name"
              class="form-control">

            @error('name')
              <div class="alert alert-warning my-2">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
          <div class="form-group my-2">
            <label for="_date"><strong>Train Date:</strong></label>
            <input type="date" name="date" id="_date" class="form-control">

            @error('date')
              <div class="alert alert-warning my-2">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
          <div class="form-group my-2">
            <label for="_home_station"><strong>Home Station:</strong></label>
            <input list="home_stations" name="home_station_id" id="_home_station"
              placeholder="Type or select station name" value="{{ old('home_station_id') }}" class="form-control">
            <datalist id="home_stations">
              @foreach ($stations as $station)
                <option value="{{ $station->id }}">
                  {{ $station->id . ' - ' . $station->name }}</option>
              @endforeach
            </datalist>

            @error('home_station_id')
              <div class="alert alert-warning my-2">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
          <div class="form-group my-2">
            <label for="_start_time"><strong>Start Time:</strong></label>
            <input type="time" name="start_time" id="_start_time" class="form-control">

            @error('start_time')
              <div class="alert alert-warning my-2">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <input type="submit" value="Add Train" class="btn btn-outline-primary">
        </div>
      </form>

    </div>

  </div>
@endsection
