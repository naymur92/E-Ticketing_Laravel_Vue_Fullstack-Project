@extends('layouts.app')

@section('title', 'Bogi Types')

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
    <h1 class="h3 mb-2 text-gray-800">Bogi Types</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        {{-- Bogi add form --}}
        <div class="card shadow my-3">
          <div class="card-header">
            <h3 class="text-center m-0 font-weight-bold text-primary">Bogi @isset($bogi_type)
                Update
              @else
                Add
              @endisset Form</h3>
          </div>
          <div class="card-body">
            @if (isset($bogi_type))
              {{-- edit part --}}
              <form action="{{ route('bogi-types.update', $bogi_type->id) }}" method="post">
                @method('put')
              @else
                {{-- add part --}}
                <form action="{{ route('bogi-types.store') }}" method="post">
            @endif
            @csrf
            <div class="row justify-content-between align-items-end">

              <div class="col-5">
                <div class="form-group m-0">
                  <label for="_bogi_type_name"><strong>Bogi Type Name:</strong></label>
                  <input type="text" id="_bogi_type_name"
                    value="{{ isset($bogi_type) ? old('bogi_type_name', $bogi_type->bogi_type_name) : old('bogi_type_name') }}"
                    name="bogi_type_name" placeholder="Ex. snigdha, s_chair, ac_s etc."
                    class="form-control @error('bogi_type_name') is-invalid @enderror">

                  @error('bogi_type_name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="col-5">
                <div class="form-group m-0">
                  <label for="_seat_count"><strong>Total Seats in Bogi:</strong></label>
                  <input type="number" id="_seat_count" name="seat_count"
                    value="{{ isset($bogi_type) ? old('seat_count', $bogi_type->seat_count) : old('seat_count') }}"
                    placeholder="Enter total seats in bogi"
                    class="form-control @error('seat_count') is-invalid @enderror">

                  @error('seat_count')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror

                </div>
              </div>
              <div class="col-2">
                <input type="submit"
                  value="@isset($bogi_type) Update Bogi Type @else Add Bogi Type @endisset"
                  class="btn btn-success">
              </div>
            </div>
            </form>
          </div>
        </div>

        {{-- Bogi list --}}
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Bogi Types List</h5>

          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Bogi Type Name</th>
                    <th>Total Seats</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Bogi Type Name</th>
                    <th>Total Seats</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($bogi_types as $item)
                    <tr>
                      <td>{{ $item->id }}</td>
                      <td>{{ $item->bogi_type_name }}</td>
                      <td>{{ $item->seat_count }}</td>
                      <td>{{ date('d M, Y - h:i a', strtotime($item->created_at)) }}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route('bogi-types.edit', $item->id) }}"><i
                                class="fa fa-pen text-warning"></i> Edit</a>
                            <form action="{{ route('bogi-types.destroy', $item->id) }}"
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
    </div>


  </div>
@endsection
