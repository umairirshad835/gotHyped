<div class="container-fluid main-container">
    <div class="d-flex">
        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
        <!-- sidebar-toggle-->
        <a class="logo-horizontal " href="index.html">
            <img src="{{ asset('assets/images/brand/GH Logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ asset('assets/images/brand/GH Logo.png') }}" class="header-brand-img light-logo1"
                alt="logo">
        </a>
        <!-- LOGO -->
        <div class="main-header-center ms-3 d-none d-lg-block">
        </div>
        <div class="d-flex order-lg-2 ms-auto header-right-icons">
            <!-- SEARCH -->
            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
            </button>
            <div class="navbar navbar-collapse responsive-navbar p-0">
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                    <div class="d-flex order-lg-2">
                        <div class="dropdown  d-flex">
                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                            </a>
                        </div>
                        <!-- Theme-Layout -->
                        <div class="dropdown d-flex">
                            <a class="nav-link icon full-screen-link nav-link-bg">
                                <i class="fe fe-minimize fullscreen-button"></i>
                            </a>
                        </div>
                        
                        <!-- SIDE-MENU -->
                        <div class="dropdown d-flex profile-1">
                            <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                <img src="{{ asset('assets/images/users/21.jpg') }}" alt="profile-user"
                                    class="avatar  profile-user brround cover-image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <div class="drop-heading">
                                    <div class="text-center">
                                        <h5 class="text-dark mb-0 fs-14 fw-semibold">Percy Kewshun</h5>
                                        <small class="text-muted">Senior Admin</small>
                                    </div>
                                </div>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                    <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                </a>
                            </div>

                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>