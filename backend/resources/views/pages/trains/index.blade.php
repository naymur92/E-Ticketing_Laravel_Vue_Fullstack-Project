@extends('layouts.app')

@section('title', 'Train List')

@push('styles')
  <link href="/backend_assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="/backend_assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="/backend_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/backend_assets/js/demo/datatables-demo.js"></script>
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Trains</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Train List</h5>
        <a href="{{ route('trains.create') }}" class="btn btn-primary">Add Train</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Journey Time</th>
                <th>Route</th>
                <th>Bogi Number</th>
                <th>Have Schedule?</th>
                <th>Creation Time</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Journey Time</th>
                <th>Route</th>
                <th>Bogi Number</th>
                <th>Have Schedule?</th>
                <th>Creation Time</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($trains as $train)
                <tr>
                  <td>{{ $train->name }}</td>
                  <td>{{ date('d-m-Y - h:i a', strtotime($train->journey_date)) }}</td>
                  <td>
                    {{ $train->route->routes->first()->station->name }}
                    -
                    {{ $train->route->routes->last()->station->name }}
                  </td>
                  <td>
                    @if (count($train->bogis ?? []) == 0)
                      <span class="badge badge-pill badge-danger">No Bogi</span>
                    @else
                      <span class="badge badge-pill badge-success">{{ count($train->bogis) }}</span>
                    @endif
                  </td>
                  <td>
                    @if (count($train->schedules ?? []) == 0)
                      <span class="badge badge-pill badge-danger">No Schedule</span>
                    @else
                      <span class="badge badge-pill badge-success">Has Schedule</span>
                    @endif
                  </td>
                  <td>{{ date('d M, Y - H:i a', strtotime($train->created_at)) }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('trains.show', $train->id) }}"><i
                            class="fa fa-eye text-primary"></i> View</a>
                        <a class="dropdown-item" href="{{ route('trains.edit', $train->id) }}"><i
                            class="fa fa-pen text-warning"></i> Manage Bogi</a>
                        <form action="{{ route('trains.destroy', $train->id) }}"
                          onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                          @csrf
                          @method('delete')
                          <button class="dropdown-item"><i class="fa fa-trash text-danger"></i> Delete</button>
                        </form>
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
@endsection
