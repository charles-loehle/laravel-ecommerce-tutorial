<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CartController extends Controller
{
    public function addToCart(Product $product, Request $request) {
      if(session()->has('cart')) {
        $cart = new Cart(session()->get('cart'));
      } else {
        $cart = new Cart();
      }

      $cart->add($product);
     // dd($cart);

      session()->put('cart', $cart);
      notify()->success('Product added to cart');
      return redirect()->back();
    }

    public function showCart() {
      if(session()->has('cart')) {
        $cart = new Cart(session()->get('cart'));
      } else {
        $cart = null;
      }
      //dd($cart);

      return view('cart', compact('cart'));
    }

    public function updateCart(Request $request, Product $product) {
      $request->validate([
        'qty' => 'required|numeric|min:1'
      ]);

      // retrieve cart items from the session 
      $cart = new Cart(session()->get('cart'));
      $cart->updateQty($product->id, $request->qty);

      // store data in the session 
      session()->put('cart', $cart);

      notify()->success('Cart updated');
      return redirect()->back();
    }

    public function removeCart(Product $product) {
      // get cart session data
      $cart = new Cart(session()->get('cart'));
      // helper: removes the given value or array of values from the string
      //dd($cart);
      $cart->remove($product->id);
      // dd($cart);

      // if cart is empty delete cart session data
      if($cart->totalQty <= 0) {
        session()->forget('cart');
      } else {
        session()->put('cart', $cart);
      }

      notify()->success('Cart updated');
      return redirect()->back();
    }

    public function checkout($amount) {
      return view('checkout', compact('amount'));
    }

    public function charge(Request $request) {
      $charge = Stripe::charges()->create([
        'currency' => 'USD',
        'source' => $request->stripeToken,
        'amount' => $request->amount,
        'description' => 'TEST',
      ]);

      $chargeId = $charge['id'];

      // if(session()->has('cart')) {
      //   $cart = new Cart(session()->get('cart'));
      // } else {
      //   $cart = null;
      // }

      if($chargeId) {
        auth()->user()->orders()->create([
          'cart' => serialize(session()->get('cart'))
        ]);

        session()->forget('cart');
        notify()->success('Transaction completed');
        return redirect()->to('/');
      } else {
        return redirect()->back();
      }
    }
}
