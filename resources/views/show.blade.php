@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card">
    <div class="row">
      <aside class="col-sm-5 border-right">
        <section class="gallery-wrap">
          <div class="img-big-wrap">
            <div>
              <a href="">
                <img src="{{ Storage::url($product->image) }}" style="width: 100%;" alt="">
              </a>
            </div>
          </div>
        </section>
      </aside>
      <aside class="col-sm-7">
        <section class="card-body p-5">
          <h3 class="title mb-3">
            {{ $product->name }}
          </h3>

          <p class="price-detail-wrap">
            <span class="price h3 text-danger">
              <span class="currency">
                ${{ $product->price }}
              </span>
            </span>
          </p>

          <h3 class="h3">Description</h3>
          <p>{!! $product->description !!}</p>
          <h3 class="h3">Additional Information</h3>
          <p>{!! $product->additional_info !!}</p>

          <hr>

          <a href="{{ route('add.cart', [$product->id]) }}" class="btn btn-lg btn-outline-primary text-uppercase">
            Add to cart
          </a>
          
        </section>
      </aside>
    </div>
  </div>

@if (count($productFromSameCategories) > 0)
  <div class="jumbotron">
    <h3>You may also like</h3>

    <div class="row">
      @foreach ($productFromSameCategories as $product)
        <div class="col-md-4">
          <div class="car mb-4 shadow-sm">
            <img src="{{ Storage::url($product->image) }}" alt="">

            <div class="card-body">
              <p>{{ $product->name }}</p>
              <p class="card-text">
                {{ Str::limit($product->description, 120) }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="{{ route('product.view', [$product->id]) }}" class="btn btn-sm btn-outline-success">
                    View
                  </a>
                  <a href="{{ route('add.cart', [$product->id]) }}" class="btn btn-sm btn-outline-primary">
                    Add to cart
                  </a>
                </div>
                <small class="text-muted">
                  ${{ $product->price }}
                </small>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endif 
</div>
@endsection