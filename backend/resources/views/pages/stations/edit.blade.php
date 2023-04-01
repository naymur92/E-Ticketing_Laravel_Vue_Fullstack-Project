@extends('layouts.app')

@section('title', 'Edit Station')

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Station</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">{{ $station->name }}</h5>
        <a href="{{ route('stations.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <div class="card-body row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12">
          <form action="{{ route('stations.update', $station->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card">
              <div class="card-header">
                <h6>Station Info</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-group">
                      <label for="_name"><strong>Station Name</strong></label>
                      <input type="text" id="_name" name="name" value="{{ old('name', $station->name) }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Station Name">
                    </div>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="_address"><strong>Station Address</strong></label>
                      <input type="text" id="_address" name="address" value="{{ old('address', $station->address) }}"
                        class="form-control @error('address') is-invalid @enderror" placeholder="Station Address">
                    </div>
                    @error('address')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-group">
                      <label for="_lat"><strong>Station Lattitude</strong></label>
                      <input type="number" step="any" id="_lat" name="lat"
                        value="{{ old('lat', $station->lat) }}" class="form-control @error('lat') is-invalid @enderror"
                        placeholder="Station Lattitude">
                    </div>
                    @error('lat')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="_lon"><strong>Station Longitude</strong></label>
                      <input type="text" id="_lon" name="lon" value="{{ old('lon', $station->lon) }}"
                        class="form-control @error('lon') is-invalid @enderror" placeholder="Station Address">
                    </div>
                    @error('lon')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>

              </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-primary">Update Station</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
@endsection
