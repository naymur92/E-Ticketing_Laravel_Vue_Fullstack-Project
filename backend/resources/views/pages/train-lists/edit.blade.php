@extends('layouts.app')

@section('title', 'Edit Root Train')

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Root Train</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">{{ $root_train->train_name }}</h5>
        <a href="{{ route('train-lists.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <div class="card-body row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12">
          <form action="{{ route('train-lists.update', $root_train->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">

              {{-- Train Name section --}}
              <div class="form-group">
                <label for="_name"><strong>Train Name:</strong></label>
                <input type="text" id="_name" name="train_name"
                  value="{{ old('train_name', $root_train->train_name) }}" placeholder="Enter Train Name"
                  class="form-control @error('train_name') is-invalid @enderror">

                @error('train_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="row">
                <div class="col-6">
                  <label for="_offday"><strong>Select Off-Day:</strong></label>
                  <select name="off_day" id="_offday" class="form-control @error('off_day') is-invalid @enderror">
                    <option value="" selected disabled>Select One</option>
                    <option value="Saturday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Saturday
                    </option>
                    <option value="Sunday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Sunday</option>
                    <option value="Monday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Monday</option>
                    <option value="Tuesday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Tuesday
                    </option>
                    <option value="Wednesday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Wednesday
                    </option>
                    <option value="Thursday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Thursday
                    </option>
                    <option value="Friday" {{ old('off_day', $root_train->off_day) ? 'selected' : '' }}>Friday
                    </option>
                  </select>
                  @error('off_day')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="col-6">
                  <label for="_up_down"><strong>Select Up/Down:</strong></label>
                  <select name="up_down" id="_up_down" class="form-control @error('up_down') is-invalid @enderror">
                    <option value="" selected disabled>Select One</option>
                    <option value="0" {{ old('up_down', $root_train->up_down) == '0' ? 'selected' : '' }}>Up
                    </option>
                    <option value="1" {{ old('up_down', $root_train->up_down) ? 'selected' : '' }}>Down</option>
                  </select>
                  @error('up_down')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>

              </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-primary">Update Root Train</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
@endsection
