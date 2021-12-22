<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\Sendmail;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class CartController extends Controller
{
    public function addToCart(Product $product, Request $request)
    {
        if (session()->has("cart")) {
            $cart = new Cart(session()->get("cart"));
        } else {
            $cart = new Cart();
        }

        $cart->add($product);
        // dd($cart);

        session()->put("cart", $cart);
        notify()->success("Product added to cart");
        return redirect()->back();
    }

    public function showCart()
    {
        if (session()->has("cart")) {
            $cart = new Cart(session()->get("cart"));
        } else {
            $cart = null;
        }
        //dd($cart);

        return view("cart", compact("cart"));
    }

    public function updateCart(Request $request, Product $product)
    {
        $request->validate([
            "qty" => "required|numeric|min:1",
        ]);

        // retrieve cart items from the session
        $cart = new Cart(session()->get("cart"));
        $cart->updateQty($product->id, $request->qty);

        // store data in the session
        session()->put("cart", $cart);

        notify()->success("Cart updated");
        return redirect()->back();
    }

    public function removeCart(Product $product)
    {
        // get cart session data
        $cart = new Cart(session()->get("cart"));
        // helper: removes the given value or array of values from the string
        //dd($cart);
        $cart->remove($product->id);
        // dd($cart);

        // if cart is empty delete cart session data
        if ($cart->totalQty <= 0) {
            session()->forget("cart");
        } else {
            session()->put("cart", $cart);
        }

        notify()->success("Cart updated");
        return redirect()->back();
    }

    public function checkout($amount)
    {
        if (session()->has("cart")) {
            $cart = new Cart(session()->get("cart"));
        } else {
            $cart = null;
        }

        return view("checkout", compact("amount", "cart"));
    }

    public function charge(Request $request)
    {
        //dd($request->stripeToken);
        //return $request->stripeToken;
        $charge = Stripe::charges()->create([
            "currency" => "USD",
            "source" => $request->stripeToken,
            "amount" => $request->amount,
            "description" => "TEST",
        ]);

        $chargeId = $charge["id"];

        if (session()->has("cart")) {
            $cart = new Cart(session()->get("cart"));
        } else {
            $cart = null;
        }

        \Mail::to(auth()->user()->email)->send(new Sendmail($cart));

        if ($chargeId) {
            auth()
                ->user()
                ->orders()
                ->create([
                    "cart" => serialize(session()->get("cart")),
                ]);

            session()->forget("cart");
            notify()->success("Transaction completed");

            return redirect()->to("/");
        } else {
            return redirect()->back();
        }
    }

    /**
     * The transform method iterates over the collection and calls the given callback with each item in the collection. The items in the collection will be replaced by the values returned by the callback. Unlike most other collection methods, transform modifies the collection itself. If you wish to create a new collection instead, use the map method.
     *
     *
     */
    public function order()
    {
        $orders = auth()->user()->orders;
        // loop over the orders->cart serialized data and unserialize it.
        $carts = $orders->transform(function ($order, $key) {
            return unserialize($order->cart);
        });

        //return $carts;

        return view("order", compact("carts"));
    }
}
