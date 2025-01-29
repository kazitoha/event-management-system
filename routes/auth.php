<?php

// Default page to load
$page = $_GET['page'] ?? 'login';



// Define routing logic
switch ($page) {
    case 'login':
        $viewFile = __DIR__ . '/../views/auth/login.php';
        break;

    default:
        $breadcrumb = ['Error', 'Page Not Found'];
        $viewFile = __DIR__ . '/../views/auth/login.php';
        break;
}

// Include the resolved view file
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    // Fallback for missing files
    include __DIR__ . '/../views/login.php';
}
