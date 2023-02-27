@extends('layouts.app')

@section('title', 'Show Route')

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Route Details</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">{{ $route->from_station . ' - ' . $route->to_station }}</h5>
            <a href="{{ route('routes.index') }}" class="btn btn-outline-warning">Back</a>
          </div>

          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <th>Train Name</th>
                <td>{{ $route->train_name }}</td>
              </tr>
              <tr>
                <th>From Station</th>
                <td>{{ $route->from_station }}</td>
              </tr>
              <tr>
                <th>To Station</th>
                <td>{{ $route->to_station }}</td>
              </tr>
              <tr>
                <th>Total Time (hour:min)</th>
                <td>{{ $route->total_time }}</td>
              </tr>
              <tr>
                <th>Off Day</th>
                <td>{{ $route->off_day }}</td>
              </tr>
              <tr>
                <th>Stations List</th>
                <td>
                  @foreach ($route->route_stations as $item)
                    <p><span class="mr-3"><strong>{{ $item->sl_no }}</strong>. </span>{{ $item->station_name }}</p>
                  @endforeach
                </td>
              </tr>
            </table>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-primary" href="{{ route('routes.index') }}">Back</a>
            <a class="btn btn-outline-primary" href="{{ route('routes.edit', $route->id) }}"><i class="fa fa-pen"></i>
              Edit</a>

            <form action="{{ route('routes.destroy', $route->id) }}"
              onsubmit="return confirm('Are you want to sure to delete?')" method="post">
              @csrf
              @method('delete')
              <button class="btn btn-outline-danger"><i class="fa fa-trash"></i> Delete</button>
            </form>
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection
