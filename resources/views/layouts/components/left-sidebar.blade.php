<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>

    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{route('dashboard')}}">
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
                    <a class="side-menu__item" data-bs-toggle="slide" href="{{route('dashboard')}}"><img src="https://img.icons8.com/external-kmg-design-detailed-outline-kmg-design/512/4a90e2/external-dashboard-user-interface-kmg-design-detailed-outline-kmg-design.png" style="width:30px;" s/> &nbsp &nbsp<span
                        class="side-menu__label">Dashboard</span></a>
                </li>

                 <li class="sub-category">
                    <h3>System Management</h3>
                </li>

                <!-- Size -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"> <img src="https://img.icons8.com/external-icongeek26-outline-icongeek26/512/4a90e2/external-measure-fitness-icongeek26-outline-icongeek26.png" style="width:25px;" />&nbsp &nbsp <span
                        class="side-menu__label">Manage Size</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addSize')}}" class="slide-item"> Add Size</a></li>
                        <li><a href="{{route('sizeList')}}" class="slide-item"> Size List</a></li>
                    </ul>
                </li>

                <!-- Category -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/external-gradak-royyan-wijaya/24/4a90e2/external-category-gradak-interface-gradak-royyan-wijaya.png" style="width:25px;" /> &nbsp &nbsp<span
                        class="side-menu__label">Manage Category</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addCategory')}}" class="slide-item"> Add Category</a></li>
                        <li><a href="{{route('categoryList')}}" class="slide-item"> Category List</a></li>
                    </ul>
                </li>

                <!-- Auctions Management -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/ios-glyphs/480/4a90e2/auction.png" style="width:25px;" /> &nbsp &nbsp<span
                        class="side-menu__label">Manage Auctions</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addProduct')}}" class="slide-item">Add Auction Item</a></li>
                        <li><a href="{{route('pendingAuctions')}}" class="slide-item">Auction Item List Pending</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/ios-glyphs/480/4a90e2/conference-background-selected.png" style="width:25px;"/> &nbsp &nbsp<span
                        class="side-menu__label">Manage Staff</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addstaff')}}" class="slide-item"> Add Staff</a></li>
                        <li><a href="{{route('staffList')}}" class="slide-item"> Staff List</a></li>
                    </ul>
                </li>

                <!-- Bid -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/wired/512/4a90e2/database.png" style="width:25px;"/>&nbsp &nbsp<span
                        class="side-menu__label">Manage Bid</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addBid')}}" class="slide-item"> Add Bids</a></li>
                        <li><a href="{{route('bidList')}}" class="slide-item"> Bid List</a></li>
                    </ul>
                </li>

                 <!-- Notifications -->
                 <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/dotty/480/4a90e2/appointment-reminders.png" style="width:25px;" /> &nbsp &nbsp<span
                        class="side-menu__label">Manage Notifications</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('addNotification')}}" class="slide-item"> Add Notification</a></li>
                        <li><a href="{{route('notificationList')}}" class="slide-item"> Notification List</a></li>
                    </ul>
                </li>

                 <li class="sub-category">
                    <h3>Reporting</h3>
                </li>
                
                <!-- Auction Report -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/ios/500/4a90e2/graph-report-script.png" style="width:25px;" /> &nbsp&nbsp<span
                        class="side-menu__label">Auction Report</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('activeAuctions')}}" class="slide-item">Active Auctions</a></li>
                        <li><a href="{{route('completedAuctions')}}" class="slide-item">Completed Auction</a></li>
                    </ul>
                </li>

                <!-- Winner Report -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/external-flatart-icons-lineal-color-flatarticons/512/4a90e2/external-winner-success-flatart-icons-lineal-color-flatarticons-3.png" style="width:25px;" />&nbsp&nbsp <span
                        class="side-menu__label">Winner Report</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('winnerList')}}" class="slide-item">Winner List</a></li>
                    </ul>
                </li>

                 <!-- Users -->
                 <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)"><img src="https://img.icons8.com/ios/500/4a90e2/checked-user-male.png" style="width:25px;" /> &nbsp&nbsp<span
                        class="side-menu__label">User Report</span><i
                        class="angle fe fe-chevron-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{route('userList')}}" class="slide-item"> User List</a></li>
                    </ul>
                </li>
                
            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </div>