@extends('layouts.app')

@section('title', 'Add Root Train')

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Root Train</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Root Train Adding Form</h5>
            <a href="{{ route('train-lists.index') }}" class="btn btn-outline-warning">Back</a>
          </div>

          <form action="{{ route('train-lists.store') }}" method="POST">
            @csrf
            <div class="card-body">

              {{-- Train Name section --}}
              <div class="form-group">
                <label for="_name"><strong>Train Name:</strong></label>
                <input type="text" id="_name" name="train_name" value="{{ old('train_name') }}"
                  placeholder="Enter Train Name" class="form-control">

                @error('train_name')
                  <div class="alert alert-warning my-2">{{ $message }}</div>
                @enderror
              </div>

              <div class="row">
                <div class="col-6">
                  <label for="_offday"><strong>Select Off-Day:</strong></label>
                  <select name="off_day" id="_offday" class="form-control">
                    <option value="" selected disabled>Select One</option>
                    <option value="Saturday" {{ old('off_day') ? 'selected' : '' }}>Saturday</option>
                    <option value="Sunday" {{ old('off_day') ? 'selected' : '' }}>Sunday</option>
                    <option value="Monday" {{ old('off_day') ? 'selected' : '' }}>Monday</option>
                    <option value="Tuesday" {{ old('off_day') ? 'selected' : '' }}>Tuesday</option>
                    <option value="Wednesday" {{ old('off_day') ? 'selected' : '' }}>Wednesday</option>
                    <option value="Thursday" {{ old('off_day') ? 'selected' : '' }}>Thursday</option>
                    <option value="Friday" {{ old('off_day') ? 'selected' : '' }}>Friday</option>
                  </select>
                  @error('off_day')
                    <div class="alert alert-warning my-2">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-6">
                  <label for="_up_down"><strong>Select Up/Down:</strong></label>
                  <select name="up_down" id="_up_down" class="form-control">
                    <option value="" selected disabled>Select One</option>
                    <option value="1" {{ old('off_day') ? 'selected' : '' }}>Up</option>
                    <option value="2" {{ old('off_day') ? 'selected' : '' }}>Down</option>
                  </select>
                  @error('up_down')
                    <div class="alert alert-warning my-2">{{ $message }}</div>
                  @enderror
                </div>

              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <input type="submit" value="SUBMIT" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>

    </div>
  @endsection
