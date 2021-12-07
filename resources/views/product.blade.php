@extends('layouts.app')

@section('content')
<div class="container">
  <main role="main">

    <section class="jumbotron text-center">
      <div class="container">
        <h1>Product Categories</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        <p>
          @foreach (App\Models\Category::all() as $category)
            <a 
              href="{{ route('product.list', [$category->slug]) }}" 
              class="btn btn-secondary"
            >
              {{ $category->name }}
            </a>
          @endforeach
        </p>
      </div>
    </section>

    <h2>Categories</h2>
    @foreach (App\Models\Category::all() as $category)
      <a 
        href="{{ route('product.list', [$category->slug]) }}" 
        class="btn btn-secondary"
      >
        {{ $category->name }}
      </a>
    @endforeach
  
    <div class="album py-5 bg-light">
      <div class="container">
        <h2>Products</h2>

        <div class="row">

          @foreach ($products as $product)
              
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img src="{{ Storage::url($product->image) }}">
    
                <div class="card-body">
                  <h5 class="card-title">
                    {{ $product->name }}
                  </h5>
                  <p class="card-text">
                    {{ Str::limit($product->description, 120) }}
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a 
                        href="{{ route('product.view', [$product->id]) }}"  class="btn btn-sm btn-outline-secondary"
                      >
                        View
                      </a>
                      <a 
                        class="addToCart btn btn-sm btn-outline-secondary" 
                        id="{{ $product->id }}"
                      >
                        Add to cart
                      </a>
                    </div>
                    <small class="text-muted">${{ $product->price }}</small>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <center>
        <a href="{{ route('more.products') }}" class="btn btn-success">
          More Products
        </a>
      </center>
    </div>
  
    <h1>Carousel</h1>

    <div class="jumbotron">
      <div id="carouselExampleFade" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

          <div class="carousel-item active">
            <div class="row">
              @foreach ($randomActiveProducts as $product)
                <div class="col-4">
                  <div class="card mb-4 shadow-sm">
                    <img src="{{ Storage::url($product->image) }}">
        
                    <div class="card-body">
                      <h5 class="card-title">
                        {{ $product->name }}
                      </h5>
                      <p class="card-text">
                        {{ Str::limit($product->description, 120) }}
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <a 
                            href="{{ route('product.view', [$product->id]) }}"  class="btn btn-sm btn-outline-secondary"
                          >
                            View
                          </a>
                          <a 
                            class="addToCart btn btn-sm btn-outline-secondary" 
                            id="{{ $product->id }}"
                          >
                            Add to cart
                          </a>
                        </div>
                        <small class="text-muted">${{ $product->price }}</small>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>

          <div class="carousel-item">
            <div class="row">
              @foreach ($randomItemProducts as $product)
                <div class="col-4">
                  <div class="card mb-4 shadow-sm">
                    <img src="{{ Storage::url($product->image) }}">
        
                    <div class="card-body">
                      <h5 class="card-title">
                        {{ $product->name }}
                      </h5>
                      <p class="card-text">
                        {{ Str::limit($product->description, 120) }}
                      </p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <a 
                            href="{{ route('product.view', [$product->id]) }}"  class="btn btn-sm btn-outline-secondary"
                          >
                            View
                          </a>
                          <a 
                            class="addToCart btn btn-sm btn-outline-secondary" 
                            id="{{ $product->id }}"
                          >
                            Add to cart
                          </a>
                        </div>
                        <small class="text-muted">${{ $product->price }}</small>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div> 

  </main>

  <footer class="text-muted">
    <div class="container">
      <p class="float-right">
        <a href="#">Back to top</a>
      </p>
      <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
      <p>New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/4.6/getting-started/introduction/">getting started guide</a>.</p>
    </div>
  </footer>
</div>
@endsection
