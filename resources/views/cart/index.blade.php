@extends('layouts.base')

@section('content')
    <style>
        .radio {

            height: 30px;
            width: 30px;
            margin-top: 50px;
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
    </style>
    <div class="container mt-5">
        <div class="row ">
            <div class="col-lg-6 col-md-12 col-12 " style=" border-right:1px solid #ccc">
                <h3 class="text-center">Shopping Cart</h3>
                @if ($data->count() > 0)
                  @php 
                    $showspping=true;
                    @endphp
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>MRP</th>
                                <th>Discount</th>
                                <th>Final Price </th>
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
                                    $total = $item->price->finalprice * $item->qty;
                                    $maintot += $total;
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name }} ({{ $item->product->flavour }} )</td>
                                    <td>₹{{ $item->price->price }}</td>
                                    <td>{{  round((($item->price['price']-$item->price['finalprice'])/$item->price['price']*100),2) }}%</td>
                                    <td>₹{{ $item->price->finalprice }}</td>
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
                                <td colspan="2">₹{{ $maintot }}
                                </td>

                            </tr>
                        </tfoot>
                    </table>
                @else
                    @php 
                    $showspping=false;
                    @endphp
                    <p class="text-center">Your cart is empty!</p>
                @endif
            </div>

            <div class="col-lg-6 col-md-12 col-12">
                @if($showspping)
                <form method="post" action="/myorder">
                    @csrf
                    <h3 class="text-center">Shipping Address</h3>
                    <div class="row mb-3">
                        <div class="col-1">
                            <input type="radio" name="address" checked class="radio" value="default">
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
                    @foreach (Auth::user()->shipping as $ship)
                        <div class="row mb-3">
                            <div class="col-1">
                                <input type="radio" name="address" class="radio" value="{{ $ship->id }}">
                            </div>
                            <div class="col-11">
                                <div class="card">
                                    <div class="card-title p-2" style="border-bottom: 0.5px solid #ccc;">
                                        <span class="text-muted">Customer Name:</span>
                                        <b> {{ $ship->name }}

                                            (+91{{ $ship->mobile }})
                                        </b>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">New Shipping Address</button>
                        <button class="btn btn-success">Place Order</button>
                    </div>
                </form>
            </div>
            @else 
                <div> Your cart is Empty.First add items in cart then shipping detail will show!
                <a href="/product/all">Shop Now</a>    
                </div> 
            @endif
        </div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <form method="POST" action="/shipping">
                    @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shipping Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="mobile" class="col-md-4 col-form-label text-md-end">{{ __('Mobile ') }}</label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">+91</span>
                                    </div>

                                    <input id="mobile" type="text" maxlength="10" oninput="validateInput(this)"
                                        class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                        value="{{ old('mobile') }}" required autocomplete="mobile">

                                    @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address"
                                class="col-md-4 col-form-label text-md-end">{{ __('Enter Address') }}</label>

                            <div class="col-md-6">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required
                                    autocomplete="address">{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button t class="btn btn-primary">Save</button>
                    </div>
                </form>
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
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            var recipient = button.getAttribute('data-bs-whatever')
            // If necessary, you could initiate an AJAX request here
            // and then do the updating in a callback.
            //
            // Update the modal's content.
            var modalTitle = exampleModal.querySelector('.modal-title')
            var modalBodyInput = exampleModal.querySelector('.modal-body input')

            modalTitle.textContent = 'New message to ' + recipient
            modalBodyInput.value = recipient
        })
    </script>
@endsection
