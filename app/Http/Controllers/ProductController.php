<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Price;
use App\Models\Media;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }
    public function listing()
    {
        //
        $data=Product::with(['price','media'])->get();
        // $info = Product::with(['price', 'media'])->find();
        // dd($info);
        return view('product.listing',compact('data'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("product.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->name = trim($request->name);
        $request->validate([
            'name' => 'required|min:3|max:40',
            'flavour' => 'required|min:3|max:40',
            'main_image' => 'required|image',
            'other_image.*' => 'nullable|image',
        ]);
        $fileimage = time() . "_main_" . ($request->main_image->getClientOriginalName());
        $request->main_image->move("./images", $fileimage);
        $productinfo = [
            'name' => $request->name,
            'flavour' => $request->flavour,
            'description' => $request->description,
            'main_image' => $fileimage
        ];
        $productobject = Product::create($productinfo);
        $n = count($request->price['madewith']);
        for ($i = 0; $i < $n; $i++) {
            $priceinfo = [
                'product_id' => $productobject->id,
                'madewith' => $request->price['madewith'][$i],
                'weight' => $request->price['weight'][$i],
                'weight_type' => $request->price['weight_type'][$i],
                'price' => $request->price['price'][$i],
                'finalprice' => $request->price['finalprice'][$i],
            ];
            Price::create($priceinfo);
        }
        $m = count($request->other_image);
        for ($i = 0; $i < $m; $i++) {
            $fileimage = time() . "_other_" . ($request->other_image[$i]->getClientOriginalName());
            $tpy = $request->other_image[$i]->getClientMimeType();
            $request->other_image[$i]->move("./images", $fileimage);

            $ofile = [
                'product_id' => $productobject->id,
                'file_path' => $fileimage,
                'file_type' => substr($tpy, 0, strpos($tpy, '/'))
            ];
            Media::create($ofile);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    
        // $cart = Cart::where('user_id', 1)->where('price_id', 7)->get();
        // dd($cart[0]);
        return view('product.show',['info'=>$product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
