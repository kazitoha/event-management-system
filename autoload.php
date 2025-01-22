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



function validateInt($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
        return $value;
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function validateFloat($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
        return $value;
    } else {
        // return "Invalid float value.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function validateString($value, $min = 1, $max = 255)
{
    $value = trim($value);
    if (is_string($value) && strlen($value) >= $min && strlen($value) <= $max) {
        return htmlspecialchars($value); // Escape special characters
    } else {
        // return "Invalid string value. Must be between $min and $max characters.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function validateEmail($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return $value;
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    };
}



function validateBoolean($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
        return $value;
    } else {
        // return "Invalid boolean value.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
