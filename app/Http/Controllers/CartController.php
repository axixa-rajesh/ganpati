<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $cart = Cart::where('user_id',(Auth::user()->id))->get();
        dd($cart);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $f=0;
        $cart=Cart::where('user_id',$request->user_id)->where('price_id',$request->price_id)->get();
        if(!count($cart)){
           $f=1;
            $cart=new Cart();
        }else{
            $cart=$cart[0];
            if(!$request->qty){
                $cart->delete();
                return "Remove Item From Cart!";
            }
        }
         $cart->product_id=$request->product_id;
        $cart->user_id=$request->user_id;
        $cart->price_id=$request->price_id;
        $cart->qty=$request->qty;
        $cart->save();
        return $f?"Item Added":"Item Updated";
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
