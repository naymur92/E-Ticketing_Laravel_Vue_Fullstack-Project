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
        <h5 class="m-0 font-weight-bold text-primary">{{ $train->name }}</h5>
        <a href="{{ route('trains.index') }}" class="btn btn-outline-warning">Back</a>
      </div>
      <div class="card-body row justify-content-center">
        <div class="col-xl-10 col-lg-10 col-md-12">
          {{-- <form action="{{ route('trains.update', $train->id) }}" method="post">
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
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="_date"><strong>Start Date</strong></label>
                      <input type="date" id="_date" name="journey_date"
                        value="{{ old('journey_date', $train->journey_date) }}" class="form-control">
                    </div>
                    @error('date')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-end mt-3">
              <button class="btn btn-primary">Update Train</button>
            </div>
          </form> --}}

          <div class="card shadow mt-3">
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

                        <h4 class="text-center">{{ $bogi->bogi_name }} ({{ $bogi->bogi_type->bogi_type_name }})</h4>
                      </div>
                      <div class="card-body px-0">
                        <ul class="bogi_list">
                          @foreach ($bogi->seats as $seat)
                            <li class="rounded {{ $seat->booked ? 'bg-danger' : 'bg-secondary' }}">
                              <span>{{ $seat->seat_name }}</span>
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
              <label for="_bogi_type_id"><strong>Bogi Name:</strong></label>
              <select name="bogi_type_id" id="_bogi_type_id"
                class="form-control @error('bogi_type_id') is-invalid @enderror">
                <option value="" selected hidden>Select One</option>
                @foreach ($bogi_types as $item)
                  <option value="{{ $item->id }}" {{ old('bogi_type_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->bogi_type_name }}</option>
                @endforeach
              </select>
              @error('bogi_type_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="_bogi_name"><strong>Bogi Name:</strong></label>
              <input type="text" id="_bogi_name" name="bogi_name" value="{{ old('bogi_name') }}"
                class="form-control @error('bogi_name') is-invalid @enderror" placeholder="Enter Bogi Name">
              @error('bogi_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
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
