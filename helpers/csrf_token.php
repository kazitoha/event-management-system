<?php
if (isset($_POST['register_attendee'])) {
    // CSRF Token generation and validation
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = generateCsrfToken();
    }


    if (!APP_DEBUG == 1) {
        // // Validate CSRF Token on POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                // Token valid, continue processing the form
                // Optionally, regenerate CSRF token after use to prevent reuse
                $_SESSION['csrf_token'] = generateCsrfToken();  // Regenerate token after successful POST
            } else {
                // CSRF token invalid
                echo "Invalid CSRF token.";
                exit();
            }
        }
        // Generate a CSRF token

    }
}

function generateCsrfToken()
{
    return bin2hex(random_bytes(32));
}
