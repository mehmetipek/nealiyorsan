<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cart = Cart::whereUserId(Auth::id())->with('auction')->get();

        return response()->json([
            'user_id' => Auth::id(),
            'data' => ['cart' => $cart, 'total' => $cart->sum('price')],
            'count' => $cart->count(),
            'status' => ($cart->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->isJson()) {
            $cart_item = json_decode($request->getContent(), true);
        } else {
            $cart_item = $request->all();
        }

        /**
         * @todo: conditions burada hesaplanacak.
         */
        if (isset($cart_item['conditions'])) {
            $cart_item['user_id'] = Auth::id();
            $cart_item['auction_id'] = null;

            Cart::create($cart_item);
        } else {
            $cart_item['conditions'] = "";
        }

        if ($cart = Cart::whereUserId(Auth::id())->whereAuctionId($cart_item['auction_id'])->first()) {
            $cart->quantity = $cart_item['quantity'];
            $cart->price = $cart_item['price'];
            $cart->currency = $cart_item['currency'];
            $cart->save();
        } else {
            $cart_item['user_id'] = Auth::id();

            Cart::create($cart_item);

            $cart = Cart::whereUserId(Auth::id())->get();
        }

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $cart,
            'count' => $cart->count(),
            'status' => ($cart->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if ($request->isJson()) {
            $cart_item = json_decode($request->getContent(), true);
        } else {
            $cart_item = $request->all();
        }

        Cart::destroy($cart_item['id']);

        $cart = Cart::whereUserId(Auth::id())->get();
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $cart,
            'count' => $cart->count(),
            'status' => ($cart->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);

    }
}
