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
                        <i class="mdi mdi-desktop-mac-dashboard"></i>
                        <span class="badge badge-pill badge-success float-right">3</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="?page=event_management" class="waves-effect <?= $current_page == 'event_management' ? 'text-white' : '' ?>">
                        <i class="fa fa-calendar-check"></i> <span>Event Management</span>
                    </a>
                </li>
                <li>
                    <a href="?page=user_management" class="waves-effect <?= $current_page == 'user_management' ? 'text-white' : '' ?>">
                        <i class="fa fa-users"></i> <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="?page=searchAcrossAndAttendees" class="waves-effect <?= $current_page == 'searchacrossandattendees' ? 'text-white' : '' ?>">
                        <i class="fa fa-search"></i> <span>Search Event/Attendee</span>
                    </a>
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