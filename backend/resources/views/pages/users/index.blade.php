@extends('layouts.app')

@section('title', 'Users List')

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
    <h1 class="h3 mb-2 text-gray-800">Users</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">User List</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-left">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="text-left">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined At</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td class="text-left">{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->is_admin }}</td>
                  <td>{{ date('d M, Y - H:i a', strtotime($user->created_at)) }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('users.show', $user['id']) }}"><i
                            class="fa fa-eye text-primary"></i> View</a>
                        <a class="dropdown-item" href="{{ route('users.edit', $user['id']) }}"><i
                            class="fa fa-pen text-warning"></i> Edit</a>
                        <form action="{{ route('users.destroy', $user['id']) }}"
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
