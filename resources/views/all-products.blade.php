@extends('layouts.app')

@section('content')
<div class="container">

  <div class="col-md-6">
    <form action="{{ route('more.products') }}" method="get">
      <div class="form-group mb-2">
        <input type="text" name="search" class="form-control" placeholder="search...">
      </div>
      <button type="submit" class="btn btn-secondary">Search</button>
    </form>
  </div>
  <br>

  <div class="row">
    @foreach ($products as $product)
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <img src="{{ Storage::url($product->image) }}" alt="">
          <div class="card-body">
            <p>{{ $product->name }}</p>
            <p class="card-text">
              {{ (Str::limit($product->description, 120)) }}
            </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a href="{{ route('product.view', [$product->id]) }}" class="btn btn-sm btn-outline-success">View</a>
                <a href="{{ route('add.cart', [$product->id]) }}" class="btn btn-sm btn-outline-primary">Add to cart</a>
              </div>
              <small class="text-muted">${{ $product->price }}</small>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $products->links() }}
</div>
@endsection