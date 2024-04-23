<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cart::where('users_id', Auth::user()->id)->get();

        return $this->sendResponse($data, 'Successfully get all cart');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $userId = Auth::user()->id;

        $cartItem = Cart::where('product_id', $data['product_id'])
            ->where('users_id', $userId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
            return $this->sendResponse($cartItem, 'Successfully update cart');
        } else {
            Cart::create([
                'users_id' => $userId,
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
            ]);
            return $this->sendResponse($data, 'Successfully create new cart');
        }
    }
    public function destroy(string $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return $this->sendResponse($cart, 'Successfully delete cart');
    }

    public function increment(Request $request){
        $data = $request->all();
        $user = Auth::user()->id;

        $cart = Cart::where('product_id', $data['product_id'])
            ->where('users_id', $user)
            ->first();

        $cart->increment('quantity');

        return $this->sendResponse($cart, 'Successfully increment cart');
    }

    public function decrement(Request $request){
        $data = $request->all();
        $user = Auth::user()->id;

        $cart = Cart::where('product_id', $data['product_id'])
            ->where('users_id', $user)
            ->first();

        if($cart['quantity'] > 1){
            $cart->decrement('quantity');
            return $this->sendResponse($cart, 'Successfully decrement cart');
        } else {
            $cart->delete();
            return $this->sendResponse($cart, 'Successfully delete cart');
        }

    }


}
