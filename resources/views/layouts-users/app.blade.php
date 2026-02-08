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
  
   @yield('content-user')
    <!-- Main Content -->



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
