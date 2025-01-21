<?php
session_start();

//auto load all classes which is located in my classes folder
require_once __DIR__ . '/autoload.php';

//connect database
$database = new Database();
$db = $database->connect();

include_once 'includes/header.php';

if (isset($_SESSION['logged_in']) && $_GET['page'] == 'logout') {
    session_destroy();
    header("Location: ?page=login");
}
// Start the session to destroy it properly

if (!isset($_SESSION['logged_in'])) {
    include_once 'routes/auth.php';
}


if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    include_once 'includes/navbar.php';
    include_once 'includes/sidebar.php';
    require_once 'includes/breadcrumb.php';



    // this is my route page
    include_once 'routes/web.php';




    include_once 'includes/footer.php';
}
