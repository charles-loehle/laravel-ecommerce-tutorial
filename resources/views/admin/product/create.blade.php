@extends('admin.layouts.main')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 ml-4 text-gray-800">Product</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Product</li>
    </ol>
  </div>

  <div class="row justify-content-center">
    @if (Session::has('message'))
      <div class="alert alert-success">
        {{ Session::get('message') }}
      </div>
    @endif

    <div class="col-lg-10" id="app">
      <form 
        action="{{ route('product.store') }}" 
        method="post" 
        enctype="multipart/form-data"
      >
        @csrf
        <div class="card mb-6">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Create Product</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input 
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter name of product"
              >
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror                
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea 
                id="summernote"
                name="description" 
                class="form-control 
                @error('description') is-invalid @enderror"
              ></textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror               
            </div>

            <div class="form-group">
              <div class="custom-file">
                <input 
                  type="file" 
                  name="image" 
                  class="custom-file-input @error('image') is-invalid @enderror"
                  id="customFile"
                >
                <label class="custom-file-label">Choose file</label>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>                
            </div>

            <div class="form-group">
              <label for="price">Price($)</label>
              <input 
                type="number" 
                name="price" 
                class="form-control @error('price') is-invalid @enderror"
              >
              @error('price')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror                
            </div>

            <div class="form-group">
              <label for="name">Additional information</label>
              <textarea 
                name="additional_info" 
                id="summernote1" 
                class="form-control @error('additional_info') is-invalid @enderror"></textarea>
                @error('additional_info')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror                
            </div>

            <div class="form-group">
              <label for="name">Choose category</label>
              <select 
                name="category" 
                class="form-control  @error('category') is-invalid @enderror">
                <option value="">
                  select
                </option>
                @foreach (App\Models\Category::all() as $key => $category)
                  <option value="{{ $category->id }}">
                    {{ $category->name }}
                  </option>    
                @endforeach
              </select>

                @error('category')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror                
            </div>

            <div class="form-group">
              <label for="">Choose Subcategory</label>
              <select 
                name="subcategory" 
                class="form-control  @error('subcategory') is-invalid @enderror">
                <option value="">
                  select
                </option>
              </select>               
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    </div>

  </div>

  <script>
    //console.log('TEST from second script tag');
    $("document").ready(function(){
     // console.log('TEST from inside document ready function');
    // when there is a change on the select category element 
    $('select[name="category"]').on('change',function(){
      //console.log('TEST the select changed');
      // get the category id from the select option value attribute
      var catId = $(this).val();
      // if there is a category selected
      if(catId){
        // make a GET request to the url 
        $.ajax({
          url:'/subcategories/'+catId,
          type:"GET",
          dataType:"json",
          // if request is 200
          success: function(data){
            // Remove child elements and any text from subcategory select.
            $('select[name="subcategory"]').empty();
            // loop through returned data 
            $.each(data,function(key, value){
              // populate the subcategories select options with categories that match category_id 
              $('select[name="subcategory"]').append('<option value=" '+key+'">'+value+'</option>');
            })
          }
        })
      }else{
        $('select[name="subcategory"]').empty();  
      }
    });
  });
  </script>
  

  @endsection