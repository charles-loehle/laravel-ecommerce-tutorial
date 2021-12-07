<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class FrontProductListController extends Controller
{
    public function index() {
      $products = Product::latest()->limit(9)->get();
      $randomActiveProducts = Product::inRandomOrder()
        ->limit(3)
        ->get();
      $randomActiveProductIds = [];
      
      foreach($randomActiveProducts as $product) {
        array_push($randomActiveProductIds, $product->id);
      }

      $randomItemProducts = Product::whereNotIn('id', $randomActiveProductIds)
        ->limit(3)
        ->get();

      return view('product', compact('products', 'randomActiveProducts', 'randomItemProducts'));
    }

    public function allProducts($name, Request $request) {
      $filterSubCategories = [];
      $category = Category::where('slug', $name)
        ->first();
      $categoryId = $category->id;
      
      // if checked 
      if($request->subcategory) {
        $products = $this->filterProducts($request);
        $filterSubCategories = $this->getSubcategoriesId($request);
      } else if($request->min || $request->max){
        $products = $this->filterByPrice($request);
      } else {
        $products = Product::where('category_id', $category->id)
          ->get();
        // dd('else');
      }

      $subcategories = Subcategory::where('category_id', $category->id)
        ->get();
      $slug = $name;

      return view('category', compact(
        'products', 
        'subcategories', 
        'slug',
        'filterSubCategories',
        'categoryId'
      ));
    }

    public function filterProducts(Request $request) {
      $subId = [];
      $subcategory = Subcategory::whereIn('id', $request->subcategory)
        ->get();

      foreach($subcategory as $sub){
        array_push($subId, $sub->id);
      }

      $products = Product::whereIn('subcategory_id', $subId)
      ->get();

      return $products;
    }

    public function filterByPrice(Request $request) {
      $categoryId = $request->categoryId;
      $product = Product::whereBetween('price', [$request->min, $request->max])
        ->where('category_id', $categoryId)
        ->get();

      return $product;
    }

    public function getSubcategoriesId(Request $request) {
      $subId = [];
      $subcategory = Subcategory::whereIn('id', $request->subcategory)
        ->get();

      foreach($subcategory as $sub){
        array_push($subId, $sub->id);
      }

      return $subId;
    }

    public function show($id) {
      $product = Product::find($id);
      // get products in same category as current product that are not the same product
      $productFromSameCategories = Product::inRandomOrder()
        ->where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->limit(3)
        ->get();

      // categories = laptops, books, phones
      // subcategories = brands
      // products = single product 

      return view('show', compact('product', 'productFromSameCategories'));
    }

    public function moreProducts(Request $request) {
      $products = Product::latest()->paginate(50);

      return view('all-products', compact('products'));
    }
}
