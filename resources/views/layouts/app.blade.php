<!DOCTYPE html>
<html lang="ar">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ setting('site_name', 'اسم الموقع') }}</title>

    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- Favicon -->
    <link rel="icon"
          href="{{ setting('site_logo') ?: asset('assets/img/kaiadmin/favicon.ico') }}"
          type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />

    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <!-- Theme Colors -->
    <style>
        :root {
            --primary-color: {{ setting('primary_color', '#198754') }};
            --secondary-color: {{ setting('secondary_color', '#20c997') }};
        }
    </style>

    @livewireStyles
</head>

<body>
    <div class="wrapper">

        <!-- Sidebar -->
        @extends('layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">

            <!-- Header -->
            <div class="main-header">

                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">

                        <a href="{{ route('admin.dashboard') }}" class="logo">
                            <img src="{{ setting('site_logo') ?: asset('assets/img/kaiadmin/logo_light.svg') }}"
                                 alt="Logo"
                                 class="navbar-brand"
                                 style="height: 40px; width: auto; object-fit: contain;" />
                        </a>

                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>

                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>

                    </div>
                </div>

                <div class="main-header">
                    <div class="main-header-logo"></div>
                    @include('layouts.navbar')
                </div>

            </div>
            <!-- End Header -->

            <div class="container">
                <div class="main-content">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </div>

                @livewireScripts
            </div>

        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>

</body>
</html>
