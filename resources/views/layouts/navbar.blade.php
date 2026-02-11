<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" dir="rtl">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item d-flex align-items-center">
                <span class="fw-bold" style="font-size: 18px;"> {{ setting('site_name', 'اسم الموقع') }} </span>
            </li>
        </ul>
        <ul class="navbar-nav topbar-nav me-md-auto align-items-center">

            {{-- شعار الموقع --}}
            <li class="nav-item d-flex align-items-center me-3">
                @if(setting('site_logo'))
                <img src="{{ setting('site_logo') }}" alt="Logo"
                    style="height: 40px; width: auto; object-fit: contain;">
                @endif
            </li>
@role('seller')
    @livewire('seller.notifications-counter')
@endrole


            {{-- اسم الموقع --}}

            {{-- المستخدم --}}
            {{-- <li class="nav-item topbar-user dropdown">
                <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown" href="#">
                    <span class="profile-username me-2 text-end">
                        <span class="op-7">مرحباً،</span>
                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn" style="text-align: right;">
                    <div class="dropdown-user-scroll scrollbar-outer">

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>

                        <li>
                            <form action="{{ route('seller.logout') }}" method="POST" class="text-center mt-2 mb-2">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </li>

                    </div>
                </ul>
            </li> --}}

        </ul>

    </div>
</nav>
