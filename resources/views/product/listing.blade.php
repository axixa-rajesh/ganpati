@extends('layouts.base')

@section('content')
  <style>
    .product-card {
      transition: transform 0.2s;
    }
    .product-card:hover {
      transform: scale(1.05);
    }
    .product-img {
      height: 200px;
      object-fit: cover;
    }
    .small{
        font-size: 0.85em;
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <h1 class="text-center mb-4">Our Products</h1>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <!-- Product 1 -->
      @foreach($data as $info)
      <div class="col">
        <div class="card product-card shadow-sm">
          <img src="/images/{{ $info['main_image'] }}" class="card-img-top product-img" alt="Product 1">
          <div class="card-body text-center">
            <h5 class="card-title text-primary">{{ $info['name'] }} <span class="text-muted small">in</span>  {{ $info['flavour'] }} <span class="text-muted small">Flavour</span> </h5>
            <p class="card-text"></p>
            <a href="/product/{{ $info['id'] }}" class="btn btn-warning">View Details</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
@endsection