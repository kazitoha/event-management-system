<?php
ob_start();
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




// CSRF Token generation and validation

// if (!isset($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = generateCsrfToken();
// }

// // Validate CSRF Token on POST requests
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
//         // Token valid, continue processing the form
//         // Optionally, regenerate CSRF token after use to prevent reuse
//         $_SESSION['csrf_token'] = generateCsrfToken();  // Regenerate token after successful POST
//     } else {
//         // CSRF token invalid
//         echo "Invalid CSRF token.";
//         exit();
//     }
// }

// Generate a CSRF token
function generateCsrfToken()
{
    return bin2hex(random_bytes(32));  // Generate a secure 64-character token
}















//connect database
$database = new Database();
$db = $database->connect();















// validation system
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
