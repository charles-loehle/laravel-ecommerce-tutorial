@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        @foreach ($carts as $cart)
          <div class="card mb-3">
            <div class="card-body">
              @foreach ($cart->items as $item)
                <span class="float-right">
                  <img src="{{ Storage::url($item['image']) }}">
                </span>

                <p>Name: {{ $item['name'] }}</p>
                <p>Price: {{ $item['price'] }}</p>
                <p>Qty: {{ $item['qty'] }}</p>
              @endforeach
            </div>
          </div>

          <p>
            <button class="btn btn-info">
              <span>
                Total price: ${{ $cart->totalPrice }}
              </span>
            </button>
          </p>

          <hr>
        @endforeach
      </div>
    </div>
  </div>

@endsection