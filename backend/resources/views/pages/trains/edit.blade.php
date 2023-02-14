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
            @method('put')
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
                      <label for="_home_station"><strong>Home Station:</strong></label>
                      <input list="home_stations" name="home_station_id" id="_home_station"
                        placeholder="Type or select station name"
                        value="{{ old('home_station_id', $train->home_station_id) }}" class="form-control">
                      <datalist id="home_stations">
                        @foreach ($stations as $station)
                          <option value="{{ $station->id }}">{{ $station->id . ' - ' . $station->name }}</option>
                        @endforeach
                      </datalist>
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
                    @error('start_time')
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
              <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#bogisCreate">Add
                Bogi</button>
            </div>
            <div class="card-body p-0">
              <div class="row">
                @foreach ($train->bogis as $bogi)
                  <div class="col-sm-6 col-lg-3">
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
                            <li class="rounded {{ $seat->booked ? 'bg-danger' : 'bg-secondary' }}">
                              <span>{{ $seat->name }}</span>
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

  {{-- Add Bogi modal --}}
  <div class="modal fade" id="bogisCreate" tabindex="-1" role="dialog" aria-labelledby="bogisCreateCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bogisCreateLongTitle">Bogi Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('bogis.store') }}" method="post">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="_bogi_name"><strong>Bogi Name:</strong></label>
              <input type="text" id="_bogi_name" name="bogi_name" value="{{ old('bogi_name') }}"
                class="form-control" placeholder="Enter Bogi Name">
              @error('bogi_name')
                <div class="alert alert-warning my-2">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <label for="_total_seats"><strong>Total Seats:</strong></label>
              <input type="number" id="_total_seats" name="total_seats" value="{{ old('total_seats') }}"
                class="form-control" placeholder="Enter total seats">
              @error('total_seats')
                <div class="alert alert-warning my-2">{{ $message }}</div>
              @enderror
            </div>
            <input type="hidden" name="train_id" value="{{ $train->id }}">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary">Add Bogi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
