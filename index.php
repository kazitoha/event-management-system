<?php
session_start();
// auto load all classes which is located in my classes folder 
// and database connection is located in this autoload
// and validation also
// and csrf token is also exist in this autoload.php
// print_r($_SESSION);
// exit;
require_once __DIR__ . '/autoload.php';

require_once 'includes/header.php';



// attendees routes
if (isset($_GET['attendees_url'])) {
    require_once 'routes/user.php';
}



// destroy the session properly
if (isset($_SESSION['logged_in']) && $_GET['page'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
}



//login routes
if (!isset($_SESSION['logged_in'])) {
    require_once 'routes/auth.php';
}




//admin routes
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    require_once 'includes/navbar.php';
    require_once 'includes/sidebar.php';
    require_once 'includes/breadcrumb.php';
    require_once 'routes/admin.php';
    require_once 'includes/footer.php';
}
