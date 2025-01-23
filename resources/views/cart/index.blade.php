@extends('layouts.base')

@section('content')
    <style>
        .radio {

            height: 30px;
            width: 30px;
            margin-top:50px; 
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
    </style>
    <div class="container mt-5">
        <div class="row ">
            <div class="col-lg-6 col-md-12 col-12 " style=" border-right:1px solid #ccc">
                <h3 class="text-center">Shopping Cart</h3>
                @if ($data->count() > 0)
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $maintot = 0;
                            @endphp
                            @foreach ($data as $item)
                                @php
                                    $total = $item->price->price * $item->qty;
                                    $maintot += $total;
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name }} ({{ $item->product->flavour }} )</td>
                                    <td>₹{{ $item->price->price }}</td>
                                    <td>
                                        <input type="number" style="width: 80px"
                                            onchange="addToCart('{{ $item->product['id'] }}','{{ Auth::user()->id }}','{{ $item->price['id'] }}',this.value)"
                                            value="{{ $item->qty }}">
                                    </td>
                                    <td>₹{{ $total }}</td>
                                    <td>
                                        <form action="/cart/{{ $item->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td  colspan="2">₹{{ $maintot }}
                                </td>
                              
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p class="text-center">Your cart is empty!</p>
                @endif
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                <form>
                <h3 class="text-center">Shipping Address</h3>
                <div class="row mb-3">
                    <div class="col-1">
                        <input type="radio" name="address" checked  class="radio" value="default">
                    </div>
                    <div class="col-11">
                        <div class="card">
                            <div class="card-title p-2" style="border-bottom: 0.5px solid #ccc;">
                                <span class="text-muted">Customer Name:</span>
                                <b> {{ Auth::user()->name }}
                                        
                                (+91{{ Auth::user()->mobile }}) </b>  
                            </div>
                            <div class="card-description p-2">
                                <span class="text-muted">Shipping Address: </span>
                                <br>
                                <b>
                                {{ Auth::user()->address }}    
                                </b>    
                            </div>    
                        </div>
                    </div>
                </div>
                @foreach(Auth::user()->shipping as $ship)
                 <div class="row mb-3">
                    <div class="col-1">
                        <input type="radio" name="address"  class="radio" value="{{ $ship->id}}">
                    </div>
                    <div class="col-11">
                        <div class="card">
                            <div class="card-title p-2" style="border-bottom: 0.5px solid #ccc;">
                                <span class="text-muted">Customer Name:</span>
                                <b> {{ $ship->name }}
                                        
                                (+91{{ $ship->mobile }}) </b> 
                            </div>
                            <div class="card-description p-2">
                                <span class="text-muted">Shipping Address: </span>
                                <br>
                                <b>
                                {{ $ship->address }}    
                                </b>    
                            </div>    
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="m-5 text-center">
                    <button class="btn btn-success">Next</button>    
                </div>
            </div>
        </div>

    </div>
    <script>
        function addToCart(product_id, user_id, price_id, qty) {

            let token = '@csrf';
            token = token.substr(42, 40);
            //let qty=document.getElementById('qty_'+price_id).value;
            if (qty) {
                let info = {
                    product_id,
                    user_id,
                    price_id,
                    qty,
                    _token: token
                };
                $.ajax({
                    url: '/cart/',
                    type: 'post',
                    data: info,
                    success: function(r) {
                        location.href = location.href;
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            } else {
                alert("Enter Quantity!");
            }
        }
    </script>
@endsection
