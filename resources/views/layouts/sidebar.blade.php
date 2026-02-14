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
                @role('admin')
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>الصفحة الرئيسية</p>
                    </a>
                </li>
                @endrole

                @role('seller')
                <li class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('seller.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>الصفحة الرئيسية</p>
                    </a>
                </li>
                @endrole

                <!-- Seller: Auctions -->
                @role('seller')
                <li class="nav-item {{ request()->routeIs('auction.index') ? 'active' : '' }}">
                    <a href="{{ route('auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-gavel me-2"></i>
                        <span>المزادات</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('seller.auctions.archive') ? 'active' : '' }}">
                    <a href="{{ route('seller.auctions.archive') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-archive me-2"></i>
                        <span>أرشيف المزادات</span>
                    </a>
                </li>
                @endrole

                <!-- Admin: Auctions & Settings -->
                @role('admin')
                <li class="nav-item {{ request()->is('admin/auction*') ? 'active' : '' }}">
                    <a href="{{ route('admin.auction.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-gavel me-2"></i>
                        <span>إدارة المزادات</span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <a href="{{ route('settings.admin.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fa fa-cog ms-2"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
                @endrole

                <!-- Profile -->
                @role('seller')
                <li class="nav-item {{ request()->routeIs('seller.profile') ? 'active' : '' }}">
                    <a href="{{ route('seller.profile') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-user me-2"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>
                @endrole

                @role('admin')
                <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                    <a href="{{ route('admin.profile') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-user me-2"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>
                @endrole

                @role('seller')
                <li class="nav-item {{ request()->routeIs('sellers.add.user') ? 'active' : '' }}">
                        <a href="{{ route('sellers.add.user') }}" class="nav-link d-flex align-items-center"
                        style="gap:8px;">
                        <i class="fas fa-user-plus" style="font-size:16px;"></i>
                        <span>إضافة مستخدم</span>
                    </a>
                </li>
                @endrole

                <!-- Logout Buttons -->
                @role('admin')
                <li class="nav-item logout-btn">
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="nav-link d-flex align-items-center text-start w-100"
                            style="background:none; border:none;">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </li>
                @endrole

                @role('seller')
                <li class="nav-item logout-btn">
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="nav-link d-flex align-items-center text-start w-100"
                            style="background:none; border:none;">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>تسجيل الخروج</span>
                        </button>
                    </form>
                </li>
                @endrole

            </ul>

        </div>
    </div>
</div>
