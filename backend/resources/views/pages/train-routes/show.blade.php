@extends('layouts.app')

@section('title', 'Show Station - ' . $station->name)

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Station Details</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">{{ $station->name }}</h5>
            <a href="{{ route('stations.index') }}" class="btn btn-outline-warning">Back</a>
          </div>

          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <th>Name</th>
                <td>{{ $station->name }}</td>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ $station->address }}</td>
              </tr>
              <tr>
                <th>Lattitude</th>
                <td>{{ $station->lat }}</td>
              </tr>
              <tr>
                <th>Longitude</th>
                <td>{{ $station->lon }}</td>
              </tr>
              <tr>
                <th>Created At</th>
                <td>{{ date('d M, Y - H:i a', strtotime($station->created_at)) }}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-warning" href="{{ route('stations.index') }}">Back</a>
            <a class="btn btn-outline-warning" href="{{ route('stations.edit', $station['id']) }}"><i
                class="fa fa-pen"></i>
              Edit</a>

            <form action="{{ route('stations.destroy', $station['id']) }}"
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
