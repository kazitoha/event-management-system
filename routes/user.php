<?php

// Validate and parse the attendees_url parameter
$attendees_url = $_GET['attendees_url'] ?? null;

// Default view file
$viewFile = __DIR__ . '/../views/404.php';



if ($attendees_url) {
    $parts = explode('/', $attendees_url);

    // Ensure the first part exists
    if (!empty($parts[0])) {
        $event_encode_id = $parts[0];
        $event_id = decode($event_encode_id);
        $attendee = new AttendeeClass($db);
        // Check if the event exists
        $checkEventDetails = $attendee->checkEventDetails($event_id);

        if (!empty($checkEventDetails)) {
            $viewFile = __DIR__ . '/../views/user/register_attendee.php';
        }
    } else {
        echo "Invalid input format.";
    }
}






// Include the resolved view file if it exists
if (file_exists($viewFile)) {
    include $viewFile;
} else {
    // Fallback for missing files
    include __DIR__ . '/../views/404.php';
}

exit;
