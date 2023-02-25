@extends('layouts.app')

@section('title', 'All Root Trains')

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
    <h1 class="h3 mb-2 text-gray-800">Root TrainList</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Train-List Table</h5>
        <a href="{{ route('train-lists.create') }}" class="btn btn-primary">Add Train</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Route ID</th>
                <th>Name</th>
                <th>Off-Day</th>
                <th>Up/Down</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Route ID</th>
                <th>Name</th>
                <th>Off-Day</th>
                <th>Up/Down</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($train_lists as $item)
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->train_name }}</td>
                  <td>{{ $item->off_day }}</td>
                  <td>
                    @if ($item->up_down == 1)
                      UP
                    @else
                      DOWN
                    @endif
                  </td>
                  <td>{{ date('d M, Y - H:i a', strtotime($item->created_at)) }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        {{-- <a class="dropdown-item" href="{{ route('train-lists.show', $item->id) }}"><i
                            class="fa fa-eye text-primary"></i> View</a> --}}
                        <a class="dropdown-item" href="{{ route('train-lists.edit', $item->id) }}"><i
                            class="fa fa-pen text-warning"></i> Edit</a>
                        <form action="{{ route('train-lists.destroy', $item->id) }}"
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
