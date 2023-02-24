@extends('layouts.app')

@section('title', 'Show User - ' . $user->name)

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Details</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h5>
            <a href="{{ route('users.index') }}" class="btn btn-outline-warning">Back</a>
          </div>

          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>Role</th>
                <td>{{ $user->is_admin }}</td>
              </tr>
              <tr>
                <th>Joined At</th>
                <td>{{ date('d M, Y - H:i a', strtotime($user->created_at)) }}</td>
              </tr>
            </table>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-warning" href="{{ route('users.index') }}">Back</a>
            <a class="btn btn-outline-warning" href="{{ route('users.edit', $user['id']) }}"><i class="fa fa-pen"></i>
              Edit</a>

            <form action="{{ route('users.destroy', $user['id']) }}"
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
