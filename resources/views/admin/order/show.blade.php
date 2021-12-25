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

    <div class="row justify-content-center">
      <div class="col-md-8">

        @foreach ($carts as $cart)
          @foreach ($cart->items as $item)
            <div class="card mb-3" style="max-width: 540px;">
              <div class="row no-gutters">
                <div class="col-md-4">
                  <img src="{{ Storage::url($item['image']) }}" width="100">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">Name: {{ $item['name'] }}</h5>
                    <p class="card-text">Price: ${{ $item['price'] }}</p>
                    <p class="card-text"><small class="text-muted">Qty: {{ $item['qty'] }}</small></p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          <button class="btn btn-success">
            Total price: ${{ $cart->totalPrice }}
          </button>
        @endforeach
    </div>
  </div>

@endsection