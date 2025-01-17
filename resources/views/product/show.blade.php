@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @php
        $product = $info;
    @endphp
    <style>
        .product-gallery {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .main-image {
            width: 100%;
            max-width: 500px;
            height: 400px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            position: relative;
        }

        .main-image:hover {
            cursor: zoom-in;
        }

        .thumbnails {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .product-details {
            margin-top: 30px;
        }

        .zoom-container {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            display: none;
        }

        video.main-video {
            width: 100%;
            height: 100%;
            display: none;
        }

        .zoomed-image {
            width: 600px;
            height: 600px;
            object-fit: contain;
            position: absolute;
            transform: translate(-50%, -50%);
            pointer-events: none;
        }
        /* CSS for the price container */
        .price-container {
            font-family: Arial, sans-serif;
            /* font-size: 20px; */
            position: relative;
        }

        .original-price {
            color: gray;
            position: relative;
            display: inline-block;
            transition: color 0.3s ease;
        }

        .original-price::after {
            content: '';
            position: absolute;
            top: 42%;
            left: 0;
            width: 0%;
            height: 1.5px;
            background: #555;
            transition: width 0.5s ease;
        }

        .discounted-price {
           
            font-weight: bold;
            font-size: 1.3em;
            opacity: 0;
            transition: opacity 0.5s ease, transform 0.5s ease;
            transform: translateY(-10px);
        }

        /* When animation triggers */
        .strike .original-price {
            color: #666;
        }

        .strike .original-price::after {
            width: 100%;
        }

        .strike .discounted-price {
            opacity: 1;
            transform: translateY(0);
        }
        .qty-container{
            display: flex;
            justify-content: space-between;
        
        }
        .qty-container div:first-child{
            width: 90%;
        
        }
        .qty-container div:last-child i{
            font-weight: bold;
            color: #900;
            font-size: 1.5em;
            padding: 2px;
            padding-top:5px; 
            margin: 1px;
            cursor: pointer;
        }
        .qty-container div:last-child i:hover{
            color: darkgreen;
        }
        .qty-container div:first-child input{
                width: 100%;
                font-size:1.3em; 
                border: none;
                outline: none;
                background-color: #eee;
                border-radius: 5px;
                padding: 3px;
                /* font-weight: bolder;           */
                color: darkblue;
        }
    </style>

    <div class="container my-5">
        <div class="row">
            <!-- Product Images and Video -->
            <div class="col-md-6">
                <div class="product-gallery">
                    <div class="main-image-container">
                        <img id="mainImage" src="/images/{{ $product['main_image'] }}" class="main-image"
                            alt="{{ $product['name'] }}">
                        <video id="mainVideo" class="main-video" controls>
                            <source src="/images/{{ $product['video'] }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <div id="zoomContainer" class="zoom-container">
                            <img id="zoomedImage" src="/images/{{ $product['main_image'] }}" class="zoomed-image"
                                alt="{{ $product['name'] }}">
                        </div>
                    </div>

                    <div class="thumbnails">
                        <img id="zoomedImage" src="/images/{{ $product['main_image'] }}" class="thumbnail" alt="Thumbnail"
                            onclick="changeImage('{{ $product['main_image'] }}')">
                        @foreach ($product['media'] as $image)
                            @if (!empty($image['file_path']) && $image['file_type'] == 'image')
                                <img src="/images/{{ $image->file_path }}" class="thumbnail" alt="Thumbnail"
                                    onclick="changeImage('{{ $image->file_path }}')">
                            @endif

                            @if (!empty($image['file_path']) && $image['file_type'] == 'video')
                                <video class="thumbnail" onclick="changeToVideo('{{ $image['file_path'] }}')" muted>
                                    <source src="/images/{{ $image['file_path'] }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <div class="product-details">
                    <h1 class="text-primary">{{ $product['name'] }}</h1>
                    <h4 class="text-muted">Flavour: {{ $product['flavour'] }}</h4>

                    <div class="row">
                        @foreach ($product['price'] as $price)
                            <div class="col-lg-6 col-md-6 col-12 mb-2">
                                <div class="card">
                                    <div class="p-1 text-center border-bottom">
                                        Made With
                                        <b class="text-primary">
                                            {{ $price['madewith'] }}
                                        </b>
                                    </div>
                                    <div class="p-1 text-center">

                                        <div class="text-success"> {{ $price['weight'] }} {{ $price['weight_type'] }}
                                            Packing </div>

                                        <div class="price-container" id="price-container">
                                            <span class="discounted-price" id="discounted-price">
                                                
                                                ₹{{ $price['finalprice'] }}</span> &nbsp;
                                            <span class="original-price" id="original-price">₹{{ $price['price'] }}</span>&nbsp;
                                            <span class="text-success" >{{  round($price['finalprice']/$price['price']*100,2) }}% off</span>
                                        </div>
                                        <div>
                                            @if (Auth::user())
                                                <div class="qty-container">
                                                    <div>
                                                        <input type="number" name="qty" class="txtbox" placeholder="Enter Quantity">
                                                    </div>
                                                    <div>
                                                        <i class="fa-solid fa-cart-plus"></i>
                                                    </div>

                                                </div>
                                            @else
                                                <a href="/login" class="btn btn-success"> Order Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                       
                    </div>
                    <p>{{ $product['description'] }}</p>

                </div>
            </div>
        </div>

        <script>
            const mainImage = document.getElementById('mainImage');
            const mainVideo = document.getElementById('mainVideo');
            const zoomContainer = document.getElementById('zoomContainer');
            const zoomedImage = document.getElementById('zoomedImage');

            // Zoom Functionality
            mainImage.addEventListener('mousemove', function(e) {
                const rect = mainImage.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                zoomContainer.style.display = 'block';
                zoomedImage.style.transform = `translate(-${x}px, -${y}px) scale(2)`;
            });

            mainImage.addEventListener('mouseleave', function() {
                zoomContainer.style.display = 'none';
            });

            // Change Main Image
            function changeImage(image) {
                mainVideo.style.display = 'none'; // Hide video
                mainImage.style.display = 'block'; // Show image
                mainImage.src = '/images/' + image;
                zoomedImage.src = '/images/' + image;
                mainVideo.stop();
            }

            // Change to Video
            function changeToVideo(video) {
                mainImage.style.display = 'none'; // Hide image
                mainVideo.style.display = 'block'; // Show video
                mainVideo.src = '/images/' + video;
                mainVideo.play(); // Auto play video
            }
              document.addEventListener('DOMContentLoaded', () => {
            const priceContainer = document.getElementsByClassName('price-container');

            // Trigger the animation after a slight delay
            setTimeout(() => {
                for(let i=0;i<priceContainer.length;i++)
                    priceContainer[i].classList.add('strike');
            }, 500); // Delay for visual effect
        });
        </script>
    @endsection
