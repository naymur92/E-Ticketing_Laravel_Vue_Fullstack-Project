@extends('layouts.app')

@section('title', 'Edit Train')

@push('styles')
  <link href="/backend_assets/css/custom.css" rel="stylesheet">
@endpush

@push('scripts')
  <script>
    $(function() {
      // This is for form
      $(".bogi_del_btn").click(function(e) {
        e.preventDefault();
        $(this).parent(".bogi_del_form").submit();
      });
    });
  </script>
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Train</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 font-weight-bold text-primary">{{ 'Train Name' }}</h5>
        <a href="{{ route('trains.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <div class="card-body row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12">
          <form action="{{ route('trains.update', $train->id) }}" method="post">
            @csrf
            <div class="card">
              <div class="card-header">
                <h6>Train Info</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-group">
                      <label for="_name"><strong>Train Name</strong></label>
                      <input type="text" id="_name" name="name" value="{{ old('name', $train->name) }}"
                        class="form-control " placeholder="Train Name">
                    </div>
                    @error('name')
                      <div class="alert alert-warning my-2">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="_date"><strong>Start Date</strong></label>
                      <input type="date" id="_date" name="date" value="{{ old('date', $train->date) }}"
                        class="form-control">
                    </div>
                    @error('date')
                      <div class="alert alert-warning my-2">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="form-group">
                      <label for="_home_station"><strong>Home Station</strong></label>
                      <input type="number" id="_home_station" name="home_station_id"
                        value="{{ old('home_station_id', $train->home_station_id) }}" class="form-control "
                        placeholder="numbers only">
                    </div>
                    @error('home_station_id')
                      <div class="alert alert-warning my-2">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="_start_time"><strong>Start Time</strong></label>
                      <input type="time" id="_start_time" name="start_time"
                        value="{{ old('start_time', $train->start_time) }}" class="form-control">
                    </div>
                    @error('date')
                      <div class="alert alert-warning my-2">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-primary">Update Train</button>
            </div>
          </form>

          <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h6>Train Bogis</h6>
              <a href="{{ route('bogis.create') }}" class="btn btn-outline-primary">Add Bogi</a>
            </div>
            <div class="card-body p-0">
              <div class="row">
                @foreach ($train->bogis as $bogi)
                  <div class="col-6">
                    <div class="card border-0">
                      <div class="card-header position-relative">
                        {{-- Bogi delete button --}}
                        <form class="bogi_del_form" action="{{ route('bogis.destroy', $bogi->id) }}"
                          onsubmit="return confirm('Are You Want to Sure?')" method="post">
                          @csrf
                          {{ method_field('DELETE') }}
                          <span class="position-absolute text-danger bogi_del_btn"
                            style="right: 20px; cursor: pointer;"><i class="fa fa-trash"></i></span>
                        </form>

                        <h4 class="text-center">{{ $bogi->name }}</h4>
                      </div>
                      <div class="card-body px-0">
                        <ul class="bogi_list">
                          @foreach ($bogi->seats as $seat)
                            <li class="rounded p-2 {{ $seat->booked ? 'bg-danger' : 'bg-secondary' }}">
                              {{ $seat->name }}
                            </li>
                          @endforeach
                        </ul>

                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection
