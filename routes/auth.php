<?php

// Default page to load
$page = $_GET['page'] ?? 'register';



// Define routing logic
switch ($page) {

    case 'register':
        $viewFile = __DIR__ . '/../views/register.php';
        break;
    case 'login':
        $viewFile = __DIR__ . '/../views/login.php';
        break;
    case 'logout':
        session_destroy();
        $viewFile = __DIR__ . '/../views/login.php';
        break;

    default:
        $breadcrumb = ['Error', 'Page Not Found'];
        $viewFile = __DIR__ . '/../views/login.php';
        break;
}

// Include the resolved view file
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    // Fallback for missing files
    include __DIR__ . '/../views/login.php';
}
