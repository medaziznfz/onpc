@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/vendors/prismjs/themes/prism.css') }}">
<style>
    /* Make carousel cover the whole page */
    .carousel {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .carousel-inner, .carousel-item {
        height: 100vh;
    }

    .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 100%;
        opacity: 0.6; /* Reduce opacity */
    }

    /* Title container */
    .title-container {
        position: absolute;
        bottom: 15%; /* Push it up slightly */
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        color: white;
        width: 90%;
        max-width: 600px;
        z-index: 10; /* Make sure it's above pagination */
    }

    .title-container h1 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .title-container p {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .next-btn {
        background-color: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        padding: 10px 20px;
        font-size: 1rem;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .next-btn:hover {
        background-color: white;
        color: black;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .title-container {
            bottom: 20%; /* Push it higher on smaller screens */
            width: 90%;
            padding: 0 20px;
        }

        .title-container h1 {
            font-size: 2rem;
        }

        .title-container p {
            font-size: 1rem;
        }

        .next-btn {
            font-size: 0.9rem;
            padding: 8px 16px;
        }
    }

    @media (max-width: 480px) {
        .title-container {
            bottom: 5%; /* Push it even higher on very small screens */
        }

        .title-container h1 {
            font-size: 1.8rem;
        }

        .title-container p {
            font-size: 0.9rem;
        }

        .next-btn {
            font-size: 0.85rem;
            padding: 7px 14px;
        }
    }
</style>
@endpush

@push('content')

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('assetslogin/images/pccc.jpg') }}" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('assetslogin/images/jey.jpg') }}" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('assetslogin/images/hey.jpg') }}" class="d-block w-100" alt="Slide 3">
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>




<!-- Title Section -->
<div class="title-container">
    <h1>مرحبا بكم في منصتنا</h1>
    <p>اكتشف ميزاتنا المذهلة مع تجربة سلسة.</p>
    <a href="#" class="next-btn">التالي</a>
</div>




@endpush

@push('scripts')
<script src="{{ asset('assets/vendors/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/vendors/clipboard/clipboard.min.js') }}"></script>
@endpush
