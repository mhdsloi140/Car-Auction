<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            {{-- <a href="index.html" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a> --}}
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
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span>
                    </a>

                </li>

                @role('admin')
                <li class="nav-item">
                    <a href="{{ route('brand.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-layer-group me-2"></i>
                        <span>العلامات التجارية</span>
                    </a>
                </li>
                @endrole
                @role('seller')

                <li class="nav-item">
                    <a href="{{ route('auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-layer-group me-2"></i>
                        <span>المزادات </span>
                    </a>
                </li>
                @endrole
                @role('admin')

                <li class="nav-item">
                    <a href="{{ route('admin.auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-layer-group me-2"></i>
                        <span>المزادات </span>
                    </a>
                </li>
                @endrole
                {{-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts">
                        <i class="fas fa-th-list"></i>
                        <p>Sidebar Layouts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="sidebar-style-2.html">
                                    <span class="sub-item">Sidebar Style 2</span>
                                </a>
                            </li>
                            <li>
                                <a href="icon-menu.html">
                                    <span class="sub-item">Icon Menu</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}






            </ul>
        </div>
    </div>
</div>
