<?php
$page = $_GET['page'] ?? 'dashboard';

if (isset($_GET['page'])) {
    $page = ucfirst($_GET['page']);
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $page ?> | E M S - Event Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->

    <link rel="shortcut icon" href="#">

    <!-- slick css -->
    <link href="assets/libs/slick-slider/slick/slick.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/slick-slider/slick/slick-theme.css" rel="stylesheet" type="text/css" />

    <!-- jvectormap -->
    <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />


</head>