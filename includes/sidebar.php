<?php
// Define the current page
$current_page = strtolower($_GET['page'] ?? 'dashboard'); // Default to 'dashboard' if page is not set
?>
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="?page=dashboard" class="waves-effect <?= $current_page == 'dashboard' ? 'text-white' : '' ?>">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="badge badge-pill badge-success float-right">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="?page=user_management" class="waves-effect <?= $current_page == 'user_management' ? 'text-white' : '' ?>">
                        <i class="mdi mdi-account-group"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-multiple-outline"></i>
                        <span>Email</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="email-inbox.html">Inbox</a></li>
                        <li><a href="email-read.html">Email Read</a></li>
                        <li><a href="email-compose.html">Email Compose</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->

<!-- Left Sidebar End -->
<div class="main-content">

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="page-content">
        <div class="container-fluid">