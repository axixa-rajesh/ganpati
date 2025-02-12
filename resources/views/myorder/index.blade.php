@extends('layouts.base')

@section('content')
    <style>
        .watermark-container {
            position: relative;
            padding: 40px;
            border-radius: 12px;
            color: white;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .watermark {
            position: absolute;
            top:5%;
            right:  5%;
            /* transform: translate(-50%, -50%) rotate(-30deg);  */
            font-size: 4rem; 
            color: rgba(255, 255, 255, 0.8);
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            animation: fadeIn 2s ease-in-out infinite alternate;
        }

        .approval {
            background-color: #28a745;
            /* Green */
        }

        .pending {
            background-color: #e4d03b;
            /* Yellow */
        }

        .content {
            position: relative;
            z-index: 1;
            /* Ensure content is above watermark */
        }

        .watermark-container:hover {
            /* transform: scale(1.05); */
            /* Slightly enlarge on hover */
        }

        @keyframes fadeIn {
            0% {
                opacity: 0.1;
            }

            100% {
                opacity: 0.3;
            }
        }
    </style>
    @foreach ($data as $billno => $product)
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="watermark-container {{ $product[1] == 'yes' ? 'approval' : 'pending' }}">
                        <div class="watermark">{{ $product[1] == 'yes' ? 'Approval' : 'Pending' }}</div>
                        <div class="content">
                            <h2>Slip Number: {{ $billno }}</h2>
                            <div class=" p-3 m-3 text-black">
                                <p>
                                    <b>Shipping Detail:</b>

                                    {{ $product[0][0]['name'] }} - {{ $product[0][0]['mobile'] }},
                                    <br>
                                    {{ $product[0][0]['address'] }}
                                </p>
                            </div>
                            <div class="row">
                                @foreach ($product[0] as $info)
                                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                                        <div class="card product-card shadow-sm">
                                            <img src="/images/{{ $info['product']['main_image'] }}"
                                                class="card-img-top product-img" alt="Product 1">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-primary">{{ $info['product_name'] }} <span
                                                        class="text-muted small">in</span> {{ $info['flavour'] }} <span
                                                        class="text-muted small">Flavour</span> </h5>
                                                <h6>
                                                    ({{ $info['weight'] }} - {{ $info['weight_type'] }} in
                                                    {{ $info['madewith'] }})
                                                </h6>
                                                <div class="card-text">
                                                    <div class="text-primary">
                                                        <del class="text-primary"> ₹{{ $info['mrp'] }}</del>
                                                        {{ $info['discount'] }} %off ₹{{ $info['price'] }} *
                                                        {{ $info['qty'] }}= ₹{{ $info['finalprice'] }}
                                                    </div>
                                                </div>
                                                {{-- <div>
                                                    <p>
                                                        <b>Shipping Detail:</b>

                                                        {{ $info['name'] }} - {{ $info['mobile'] }},
                                                        <br>
                                                        {{ $info['address'] }}
                                                    </p>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
@endsection
