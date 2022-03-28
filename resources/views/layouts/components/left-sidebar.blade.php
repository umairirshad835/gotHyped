<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>

    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="#">
                <img src="{{ asset('assets/images/brand/GH Logo.png') }}" class="header-brand-img light-logo1"
                    alt="logo" style="width:90%;">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                    fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="#"><i
                        class="side-menu__icon fe fe-home"></i><span
                        class="side-menu__label">Dashboard</span></a>
                </li>

                <!-- Auctions Management -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Auctions</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('pendingAuctions')}}" class="slide-item">Pending Auctions</a></li>
                        <li><a href="{{route('activeAuctions')}}" class="slide-item">Active Auctions</a></li>
                        <li><a href="{{route('expiredAuctions')}}" class="slide-item">Expired Auctions</a></li>
                    </ul>
                </li>

                <!-- Product -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Products</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addProduct')}}" class="slide-item"> Add Product</a></li>
                        <li><a href="{{route('productList')}}" class="slide-item"> Product List</a></li>
                    </ul>
                </li> 

                <!-- Category -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Category</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addCategory')}}" class="slide-item"> Add Category</a></li>
                        <li><a href="{{route('categoryList')}}" class="slide-item"> Category List</a></li>
                    </ul>
                </li>

                <!-- Size -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Size</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addSize')}}" class="slide-item"> Add Size</a></li>
                        <li><a href="{{route('sizeList')}}" class="slide-item"> Size List</a></li>
                    </ul>
                </li>

                <!-- <li class="sub-category">
                    <h3>Staff</h3>
                </li> -->

                <!-- Staff -->

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Staff</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addstaff')}}" class="slide-item"> Add Staff</a></li>
                        <li><a href="{{route('staffList')}}" class="slide-item"> Staff List</a></li>
                    </ul>
                </li> 

                <!-- Bid -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Bid</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addBid')}}" class="slide-item"> Add Bid</a></li>
                        <li><a href="{{route('bidList')}}" class="slide-item"> Bid List</a></li>
                    </ul>
                </li>

                 <!-- Notifications -->
                 <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><i
                        class="side-menu__icon fe fe-slack"></i><span
                        class="side-menu__label">Manage Notifications</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addNotification')}}" class="slide-item"> Add Notification</a></li>
                        <li><a href="{{route('notificationList')}}" class="slide-item"> Notification List</a></li>
                    </ul>
                </li>
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>