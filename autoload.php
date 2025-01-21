<?php

spl_autoload_register(function ($class) {
    // Define the base directory for the classes
    $baseDir = __DIR__ . '/classes/'; // Use an absolute path to your classes directory

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
