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

Route::get('/checkout/{amount}', [CartController::class, 'checkout'])
  ->name('cart.checkout')->middleware('auth');
Route::post('/charge', [CartController::class, 'charge'])
  ->name('cart.charge');
Route::get('/addToCart/{product}', [CartController::class, 'addToCart'])
  ->name('add.cart');
Route::get('/cart', [CartController::class, 'showCart'])
  ->name('cart.show');
Route::post('/products/{product}', [CartController::class, 'updateCart'])
  ->name('cart.update');
Route::post('/product/{product}', [CartController::class, 'removeCart'])
  ->name('cart.remove');

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




