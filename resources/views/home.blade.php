@extends('layouts.base')

@section('content')
    

    <!-- Products Section -->
    <div class="container mt-5" id="products">
        <h2 class="text-center mb-4">Our Special Sweets</h2>
        <div class="row">
            <!-- Product Card -->
            @for ($i = 0; $i < 6; $i++)
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Sweet">
                        <div class="card-body">
                            <h5 class="card-title">Sweet Name</h5>
                            <p class="card-text">A short description of the sweet.</p>
                            <a href="#" class="btn btn-outline-primary">Order Now</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
@endsection
