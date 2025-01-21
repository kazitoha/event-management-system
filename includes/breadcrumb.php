<?php
$page = $_GET['page'] ?? 'dashboard';

if (isset($_GET['page'])) {
    $page = ucfirst($_GET['page']);
}

?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">
                E M S
            </h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="index.php?page=dashboard">Event Management System</a></li>
                    <li class="breadcrumb-item"><?= $page ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->