@extends('admin.layouts.main')

@section('content')

  <div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Orders</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="./">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active" aria-current="page">Orders</li>
      </ol>
    </div>

    <div class="row">
      <div class="col-lg-12 mb-4">
        <!-- Category Tables -->
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                @if (count($orders) > 0)
                  @foreach ($orders as $key => $order)
                    <tr>
                      <td><a href="#">{{ $key + 1 }}</a></td>
                      <td>{{ $order->user->name }}</td>
                      <td>{{ $order->user->email }}</td>
                      <td>{{ date('M-d-y', strtotime($order->created_at)) }}</td>
                      <td>{{ $order->status }}</td>
                      <td>
                        <a class="btn btn-info" href="{{ route('user.order', [$order->user_id, $order->id]) }}">View</a>
                      </td>
                    </tr>
                  @endforeach
                    
                @else 
                    <td>No orders created yet.</td>
                @endif

              </tbody>
            </table>
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
    </div>
    <!--Row-->
  </div>
  <!---Container Fluid-->

@endsection