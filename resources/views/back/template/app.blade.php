<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | BALAI KESELAMATAN DAN KESEHATAN KERJA MEDAN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('back') }}/assets/images/logo-header.png">

    <!-- App css -->
    <link href="{{ asset('back') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('back') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    @yield('css')

</head>

<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid"
    data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">


            <!-- LOGO -->
            <a href="{{ route('admin.dashboard') }}" class="logo text-center text-primary">
                <span class="logo-lg align-items-center w-auto">
                    <img src="{{ asset('back') }}/assets/images/logo-2.png" alt="" style="max-height: 50px;">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('back') }}/assets/images/logo.png" alt="" style="max-height: 50px;">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>

                    <li class="side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.blogs*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.blogs') }}"
                            class="side-nav-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                            <i class="uil-copy-alt"></i>
                            <span> Blogs </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.pages*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.pages') }}"
                            class="side-nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                            <i class="uil-copy-alt"></i>
                            <span> Pages </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.sliders*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.sliders') }}"
                            class="side-nav-link {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                            <i class="uil-copy-alt"></i>
                            <span> Sliders </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.contacts*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.contacts') }}"
                            class="side-nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                            <i class="uil-copy-alt"></i>
                            <span> Contacts </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.profile*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.profile') }}"
                            class="side-nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                            <i class="uil-info-circle"></i>
                            <span> Profile </span>
                        </a>
                    </li>
                    <li class="side-nav-item {{ request()->routeIs('admin.pengaduan*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.pengaduan') }}"
                            class="side-nav-link {{ request()->routeIs('admin.pengaduan*') ? 'active' : '' }}">
                            <i class="uil-comment-question"></i>
                            <span> Pengaduan </span>
                        </a>
                    </li>

                    <li class="side-nav-title side-nav-item">Users</li>
                    <li class="side-nav-item {{ request()->routeIs('admin.users*') ? 'menuitem-active' : '' }}">
                        <a href="{{ route('admin.users') }}"
                            class="side-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <i class="uil-users-alt"></i>
                            <span> Manage Users </span>
                        </a>
                    </li>
                </ul>


                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">


                        <li class="notification-list">
                            <a class="nav-link" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-link nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ asset('back') }}/assets/images/profile.jpg" alt="user-image"
                                        class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{ ucwords(auth()->user()->name) }}</span>
                                    <span
                                        class="account-position">{{ ucwords(str_replace('_', ' ', auth()->user()->tipe)) }}</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                                style="">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Settings</span>
                                </a>
                                <!-- item-->
                                <a href="{{ route('auth.logout') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Balai K3</a></li>
                                        <li class="breadcrumb-item active">@yield('title')</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">@yield('title')</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @yield('content')

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Balai K3 Medan
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="{{ asset('back') }}/assets/js/vendor.min.js"></script>
    <script src="{{ asset('back') }}/assets/js/app.min.js"></script>

    <!-- third party js -->
    <script src="{{ asset('back') }}/assets/js/vendor/chart.min.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="{{ asset('back') }}/assets/js/pages/demo.dashboard-projects.js"></script>
    <!-- end demo js-->

    @yield('js')

</body>

</html>
