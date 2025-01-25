<?php

// Default page to load
$page = $_GET['page'] ?? 'dashboard';


// Define routing logic
switch ($page) {
    case 'dashboard':
        $viewFile = __DIR__ . '/../views/user/dashboard.php';
        break;

    default:
        $breadcrumb = ['Error', 'Page Not Found'];
        $viewFile = __DIR__ . '/../views/404.php';
        break;
}



// Include the resolved view file
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    // Fallback for missing files
    include __DIR__ . '/../views/404.php';
}
