<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\FrontProductListController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [FrontProductListController::class, 'index']);
Route::get('/product/{id}', [FrontProductListController::class, 'show'])
  ->name('product.view');
Route::get('all/products', [FrontProductListController::class, 'moreProducts'])
  ->name('more.products');

Route::get('/category/{name}', [FrontProductListController::class, 'allProducts'])
  ->name('product.list');

Route::get('/addToCart/{product}', [CartController::class, 'addToCart'])
  ->name('add.cart');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
  ->name('home');
Route::get('subcategories/{id}', [ProductController::class, 'loadSubCategories']);

Route::group(['prefix' => 'auth', 'middleware' => ['auth', 'isAdmin']], function () {
  Route::get('/dashboard', function () {
    return view('admin.dashboard');
  });
  Route::resource('category', CategoryController::class);
  Route::resource('subcategory', SubcategoryController::class);
  Route::resource('product', ProductController::class);
});




