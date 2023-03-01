@extends('layouts.app')

@section('title', 'Add Schedule')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Schedule</h1>

    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Schedule Adding Form</h5>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-warning">Back</a>
          </div>
          <add-schedule></add-schedule>

        </div>
      </div>
    </div>


  </div>
@endsection
