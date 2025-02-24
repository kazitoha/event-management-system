<?php
ob_start();


require_once 'config.php';

// error reporting
if (APP_DEBUG == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}


date_default_timezone_set(BASE_TIME);

foreach (glob(__DIR__ . '/helpers/*.php') as $filename) {
    require_once $filename;
}



spl_autoload_register(function ($class) {
    // Define the base directory for the classes
    $baseDir = __DIR__ . '/classes/';

    // Convert the class name to a file path
    $file = $baseDir . $class . '.php';

    // Check if the file exists and include it
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Debugging: Output if the class file is not found
        echo "Class file for '$class' not found: $file\n";
    }
});








//connect database
$database = new DatabaseClass();
$db = $database->connect();
