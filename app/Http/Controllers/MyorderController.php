<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Billno;
use App\Models\Myorder;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data=Myorder::where('user_id',Auth::user()->id)->orderBy('billno_id','desc')->get();
        $billwisedata=[];
        foreach($data as $info){
            $billwisedata[$info['billno_id']][0][] = $info;
             $billwisedata[$info['billno_id']][1]= Billno::find($info['billno_id'])['status'];
        }
       return view("myorder.index",['data'=>$billwisedata]);
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
        $billobj = Billno::create([]);
        //['finalprice', 'mrp', 'madewith', 'weight_type', 'weight', 'qty', 'flavour', 'product_name', 'address', 'mobile', 'name', 'user_id', 'billno_id'];
        $data = Cart::where('user_id', (Auth::user()->id))->get();
        if ($request->address == 'default') {
            $address = Auth::user()->address;
            $mobile = Auth::user()->mobile;
            $name = Auth::user()->name;
        } else {
            $sp = Shipping::find($request->address);
            $address =   $sp->address;
            $mobile =    $sp->mobile;
            $name = $sp->name;
        }
        foreach ($data as $info) {
            $info = [
                'finalprice' => $info->price->finalprice * $info->qty,
                'price'=> $info->price->finalprice,
                'discount'=>(  round((($info->price['price']- $info->price['finalprice'])/ $info->price['price']*100),2) ),
                'mrp' => $info->price->price,
                'madewith' => $info->price->madewith,
                'weight_type' => $info->price->weight_type,
                'weight' => $info->price->weight,
                'qty' => $info->qty,
                'flavour' => $info->product->flavour,
                'product_name' => $info->product->name,
                'product_id' => $info->product->id,
                'address'=>$address,
                'mobile' => $mobile,
                'name' => $name,
                'user_id' => Auth::user()->id,
                'billno_id' => $billobj->id,
            ];
            Myorder::create($info);

        }
        Cart::where('user_id', Auth::user()->id)->delete();
        return redirect('/myorder');
    }

    /**
     * Display the specified resource.
     */
    public function show(Myorder $myorder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Myorder $myorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Myorder $myorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Myorder $myorder)
    {
        //
    }
}
