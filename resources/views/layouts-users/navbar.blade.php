<!-- Logo + Login Row (Top) -->
<div class="container-fluid bg-white py-3 px-5 logo-wrapper d-flex justify-content-between align-items-center">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="navbar-brand m-0 p-0">
        <img src="{{ setting('site_logo') }}" alt="{{ setting('site_name', 'اسم الموقع') }}" style="max-height:60px;">
    </a>

    <!-- Login Button (Top) -->
    @guest
    <a href="#" class="btn btn-primary rounded-pill py-2 px-4" data-bs-toggle="modal" data-bs-target="#loginModal">
        <i class="fa fa-user me-2"></i> تسجيل الدخول
    </a>
    @endguest


    @auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger rounded-pill py-2 px-4">
            <i class="fa fa-sign-out-alt me-2"></i> تسجيل خروج
        </button>
    </form>
    @endauth


</div>


<!-- Navbar Row (Bottom) -->
<div class="container-fluid nav-bar p-0">
    <div class="row gx-0 bg-primary px-5 align-items-center">

        <!-- Sidebar Categories (Desktop) -->
        <div class="col-lg-3 d-none d-lg-block">
            <nav class="navbar navbar-light position-relative" style="width: 250px;">
                <div class="collapse navbar-collapse rounded-bottom" id="allCat">
                    <ul class="list-unstyled categories-bars">
                        <li><a class="categories-bars-item" href="#">Accessories <span>(3)</span></a></li>
                        <li><a class="categories-bars-item" href="#">Electronics & Computer <span>(5)</span></a></li>
                        <li><a class="categories-bars-item" href="#">Laptops & Desktops <span>(2)</span></a></li>
                        <li><a class="categories-bars-item" href="#">Mobiles & Tablets <span>(8)</span></a></li>
                        <li><a class="categories-bars-item" href="#">SmartPhone & Smart TV <span>(5)</span></a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Main Navbar -->
        <div class="col-12 col-lg-9">
            <nav class="navbar navbar-expand-lg navbar-light bg-primary py-3 px-0">



                <!-- Toggler -->
                <button class="navbar-toggler ms-auto me-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars fa-1x text-white"></span>
                </button>

                <!-- Navbar Links -->
                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse" style="padding-right: 60px">
                    <div class="navbar-nav py-0">
                        <a href="{{ url('/') }}" class="nav-item nav-link active text-white">الصفحة الرئيسية</a>
                        <a href="#" class="nav-item nav-link text-white">المزادات</a>
                        <a href="#" class="nav-item nav-link text-white">مزاداتي</a>
                    </div>
                </div>

            </nav>
        </div>

    </div>
</div>
