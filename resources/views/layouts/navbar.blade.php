<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" dir="rtl">
    <div class="container-fluid">

        <ul class="navbar-nav topbar-nav me-md-auto align-items-center">

            {{-- البحث للجوال --}}
            {{-- <li class="nav-item topbar-icon dropdown d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="بحث ...">
                        </div>
                    </form>
                </ul>
            </li> --}}

            {{-- المستخدم --}}
            <li class="nav-item topbar-user dropdown">
                <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown" href="#">
                    <span class="profile-username me-2 text-end">
                        <span class="op-7">مرحباً،</span>
                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn" style="text-align: right;">
                    <div class="dropdown-user-scroll scrollbar-outer">


                        <li><div class="dropdown-divider"></div></li>

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
            </li>

        </ul>

    </div>
</nav>
