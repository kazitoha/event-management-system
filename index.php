<?php
session_start();
// auto load all classes which is located in my classes folder 
// and database connection is located in this autoload
// and validation also
// and csrf token is also exist in this autoload.php
require_once __DIR__ . '/autoload.php';
require_once 'includes/header.php';

// destroy the session properly
if (isset($_SESSION['logged_in']) && $_GET['page'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: ?page=login");
}



if (!isset($_SESSION['logged_in'])) {
    require_once 'routes/auth.php';
}


// print_r($_SESSION);
// exit;


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {

    require_once 'includes/navbar.php';

    // this is my route pages
    if (isset($_SESSION['user']) && $_SESSION['user'] == 1) {
        require_once 'includes/admin_sidebar.php';
        require_once 'includes/breadcrumb.php';
        require_once 'routes/user.php';
    } elseif (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        require_once 'includes/admin_sidebar.php';
        require_once 'includes/breadcrumb.php';
        require_once 'routes/admin.php';
    }


    require_once 'includes/footer.php';
}
