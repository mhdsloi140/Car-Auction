<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">

        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

            {{-- البحث للجوال --}}
            <li class="nav-item topbar-icon dropdown d-flex d-lg-none">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search ...">
                        </div>
                    </form>
                </ul>
            </li>

            {{-- المستخدم --}}
            <li class="nav-item topbar-user dropdown">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#">
                    <span class="profile-username ms-2">
                        <span class="op-7">Hi,</span>
                        <span class="fw-bold">{{ auth()->user()->name }}</span>
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">

                        
                        <li>
                            <div class="user-box text-center">
                                <div class="u-text">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p class="text-muted">{{ auth()->user()->phone }}</p>
                                    <a href="#" class="btn btn-xs btn-secondary btn-sm">
                                        الملف الشخصي
                                    </a>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>

                            
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
