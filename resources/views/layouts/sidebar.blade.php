<!-- Sidebar -->
<div class="sidebar" dir="rtl" data-background-color="dark">


    <div class="sidebar-logo">
        <div class="logo-header d-flex justify-content-between align-items-center" data-background-color="dark">


            <div class="nav-toggle d-flex align-items-center">


                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>


                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>

            </div>

            <!-- زر المزيد -->
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
    </div>


    <!-- Sidebar Content -->
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            <ul class="nav nav-secondary">

                <!-- Dashboard -->
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>لوحة التحكم</p>
                    </a>
                </li>

            

                <!-- Seller: Auctions -->
                @role('seller')
                <li class="nav-item {{ request()->is('auction*') ? 'active' : '' }}">
                    <a href="{{ route('auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-gavel me-2"></i>
                        <span>المزادات</span>
                    </a>
                </li>
                @endrole

                <!-- Admin: Auctions -->
                @role('admin')
                <li class="nav-item {{ request()->is('admin/auction*') ? 'active' : '' }}">
                    <a href="{{ route('admin.auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-gavel me-2"></i>
                        <span>إدارة المزادات</span>
                    </a>
                </li>
                @endrole
                @role('admin')
                <li class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fa fa-cog ms-2"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
                @endrole


            </ul>

        </div>
    </div>
</div>
