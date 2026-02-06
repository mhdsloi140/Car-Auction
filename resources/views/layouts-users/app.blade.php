<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>@yield('title', setting('site_name', 'اسم الموقع'))</title>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome & Bootstrap Icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <!-- Libraries CSS -->
    <link href="{{ asset('users/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('users/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap & Custom CSS -->
    <link href="{{ asset('users/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('users/css/style.css') }}" rel="stylesheet">
    <style>.brand-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center; 
}

.brand-item {
    width: 75px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 10px;
    transition: 0.2s;
    background: #fff;
}

.brand-item:hover {
    background: #f7f7f7;
}

.brand-logo {
    width: 35px;
    height: 35px;
    object-fit: contain;
}
</style>
@livewireStyles
</head>
<body>

    <!-- Navbar -->
    @include('layouts-users.navbar')


    <!-- Hero / Carousel -->
    <div class="container-fluid carousel bg-light px-0">
        <div class="row g-0 justify-content-end">
            <div class="col-12 col-lg-7 col-xl-9">
                <div class="header-carousel owl-carousel bg-light py-5">
                    <!-- Slide 1 -->
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img wow fadeInLeft">
                            <img src="{{ asset('users/img/carousel-1.png') }}" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 wow fadeInRight" style="letter-spacing:3px;">Save Up To $400</h4>
                            <h1 class="display-3 text-capitalize mb-4 wow fadeInRight">On Selected Laptops & Desktop Or Smartphone</h1>
                            <p class="text-dark wow fadeInRight">Terms and Conditions Apply</p>
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInRight">Shop Now</a>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="row g-0 header-carousel-item align-items-center">
                        <div class="col-xl-6 carousel-img wow fadeInLeft">
                            <img src="{{ asset('users/img/carousel-2.png') }}" class="img-fluid w-100" alt="Image">
                        </div>
                        <div class="col-xl-6 carousel-content p-4">
                            <h4 class="text-uppercase fw-bold mb-4 wow fadeInRight" style="letter-spacing:3px;">Save Up To $200</h4>
                            <h1 class="display-3 text-capitalize mb-4 wow fadeInRight">On Selected Laptops & Desktop Or Smartphone</h1>
                            <p class="text-dark wow fadeInRight">Terms and Conditions Apply</p>
                            <a href="#" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInRight">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Side Banner -->
            <div class="col-12 col-lg-5 col-xl-3 wow fadeInRight">
                <div class="carousel-header-banner h-100">
                    <img src="{{ asset('users/img/header-img.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Image">
                    <div class="carousel-banner-offer">
                        <p class="bg-primary text-white rounded fs-5 py-2 px-4 mb-0 me-3">Save $48.00</p>
                        <p class="text-primary fs-5 fw-bold mb-0">Special Offer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
   @yield('content')
    <!-- Main Content -->

  <div class="container-fluid product py-5">
    <div class="container py-5">
        <div class="tab-class">

            {{-- <div class="row g-4">
                <div class="col-lg-4 text-start"></div>
                <div class="col-lg-8 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5">

                    </ul>
                </div>
            </div> --}}


            @livewire('user.auctions-list')

        </div>
    </div>
</div>


    <!-- Footer -->
    @include('layouts-users.footer')

    <!-- JS Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('users/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('users/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('users/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template JS -->
    <script src="{{ asset('users/js/main.js') }}"></script>
    @livewireScripts
     @livewire('user.login')
</body>
</html>
