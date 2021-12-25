@extends('admin.layouts.main')

@section('content')

<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="h3 mb-0 text-gray-800">Slider Tables</div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Home</a></li>
      <li class="breadcrumb-item">Slider</li>
      <li class="breadcrumb-item">Slider Tables</li>
    </ol>
  </div>

  <div class="row">
    <div class="col-log-12 mb-4">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">All Images</h6>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @if (count($sliders) > 0)
                @foreach ($sliders as $key => $slider)
                  <tr>
                    <td>
                      <a href="#">{{ $key + 1 }}</a>
                    </td>
                    <td><img src="{{ Storage::url($slider->image) }}" alt=""></td>
                    <td>
                      <form action="{{ route('slider.destroy', [$slider->id]) }}" method="post" onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                      </form>
                    </td>
                  </tr>  
                @endforeach
              @else
                <td>No slider created yet!</td>  
              @endif
            </tbody>
          </table
  
        </div>
      </div>
  </div>
</div>

@endsection