<?php
// validation system
function validateInt($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
        return $value;
    } else {
        $_SESSION['error_msg'] = "Invalid integer value.";
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback URL or error message
            header("Location: ?page=error");
        }
        exit();
    }
}

function validateFloat($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
        return $value;
    } else {
        $_SESSION['error_msg'] = "Invalid float value.";
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback URL or error message
            header("Location: ?page=error");
        }
        exit();
    }
}

function validateString($value, $min = 1, $max = 3000)
{
    $value = trim($value);

    if (is_string($value) && strlen($value) >= $min && strlen($value) <= $max) {
        return htmlspecialchars(strip_tags($value)); // Escape special characters
    } else {
        $_SESSION['error_msg'] = "Invalid string value. Length must be between $min and $max characters.";
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback URL or error message
            header("Location: ?page=error");
        }
        exit();
    }
}



function validateEmail($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
        return htmlspecialchars(strip_tags(trim($value)));
    } else {

        $_SESSION['error_msg'] = "Invalid email value.";
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback URL or error message
            header("Location: ?page=error");
        }
        exit();
    };
}


function validateBoolean($value)
{
    $value = trim($value);
    if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
        return $value;
    } else {

        $_SESSION['error_msg'] = "Invalid boolean value.";
        if (isset($_SERVER['HTTP_REFERER']) && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback URL or error message
            header("Location: ?page=error");
        }
        exit();
    }
}
