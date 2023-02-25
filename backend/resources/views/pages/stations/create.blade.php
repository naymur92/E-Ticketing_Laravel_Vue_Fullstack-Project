@extends('layouts.app')

@section('title', 'Add Train')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Station</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">Station Adding Form</h5>
        <a href="{{ route('trains.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <add-station></add-station>

    </div>

  </div>
@endsection
