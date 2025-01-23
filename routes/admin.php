<?php

// Default page to load
$page = $_GET['page'] ?? 'dashboard';

// Define routing logic
switch ($page) {
    case 'dashboard':
        $viewFile = __DIR__ . '/../views/admin/dashboard.php';
        break;
    case 'user_management':
        $viewFile = __DIR__ . '/../views/admin/manage_user.php';
        break;
    case 'events':
        $viewFile = __DIR__ . '/../views/admin/events.php';
        break;

    default:
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
