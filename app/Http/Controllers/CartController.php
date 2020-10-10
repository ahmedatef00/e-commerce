<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{


    /**
     * CartController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function showCart(Request $request){

        return view('cart.show',[
            'products' => Auth::user()->cart ? Auth::user()->cart->products : [],
            'sum' => 0
        ]);

    }

    public function addProductToCart(Request $request)
    {
    
        $userCart = Auth::user()->cart;

        // if user doesn't have a cart, create one
        if (!$userCart) {
            $userCart = Auth::user()->cart()->create();
        }
        
        $cartProduct = $userCart->products()->find(request('product_id'));
        $message = '';
        if ($cartProduct) {

            $productQuantity = $cartProduct->pivot->quantity;

            $userCart->products()->updateExistingPivot(
                request('product_id'),
                ['quantity' => $productQuantity + 1]
            );
            
            $message = 'Increased quantity';
        } else {
            $userCart->products()->attach(request('product_id'), ['quantity' => 1]);
            $message = 'Product added to cart';
        }
        return redirect(route('product.index'))->with('message',$message);

    }

    public function removeProductFromCart($product)
    {
        
        Auth::user()->cart->products()->detach([$product]);
        return redirect(route('cart.show'));
    }

    public function updateProductQuantity()
    {
        if (request('quantity') === 0) {
            $this->removeProductFromCart();
        }

        Auth::user()->cart->products()->updateExistingPivot(
            request('product_id'),
            ['quantity' => request('quantity')]
        );
    }
}
