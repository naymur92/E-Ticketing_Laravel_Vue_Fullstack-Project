@extends('layouts.app')

@section('title', 'Train Routes')

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
    <h1 class="h3 mb-2 text-gray-800">Train Routes</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Route List Table</h5>
        <a href="{{ route('routes.create') }}" class="btn btn-primary">Add Route</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Route ID</th>
                <th>Train Name</th>
                <th>From Station</th>
                <th>To Station</th>
                <th>Total Time (H:m)</th>
                <th>Off-Day</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Route ID</th>
                <th>Train Name</th>
                <th>From Station</th>
                <th>To Station</th>
                <th>Total Time (H:m)</th>
                <th>Off-Day</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($routes as $route)
                <tr>
                  <td>{{ $route->id }}</td>
                  <td>{{ $route->train_name }}</td>
                  <td>{{ $route->from_station }}</td>
                  <td>{{ $route->to_station }}</td>
                  <td>{{ $route->total_time }}</td>
                  <td>{{ $route->off_day }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('routes.show', $route->id) }}"><i
                            class="fa fa-eye text-primary"></i> View</a>
                        <a class="dropdown-item" href="{{ route('routes.edit', $route->id) }}"><i
                            class="fa fa-pen text-warning"></i> Edit</a>
                        <form action="{{ route('routes.destroy', $route->id) }}"
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
