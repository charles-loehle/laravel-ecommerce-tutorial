<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product) {
      if(session()->has('cart')) {
        $cart = new Cart(session()->get('cart'));
      } else {
        $cart = new Cart();
      }

      $cart->add($product);

    //   dd($cart);

      session()->put('cart', $cart);
      notify()->success('Product added to cart');
      return redirect()->back();
    }
}
