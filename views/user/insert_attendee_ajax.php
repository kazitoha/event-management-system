<?php
require '../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data from AJAX
    $eventId = $_POST['encode_id'];
    $maxCapacity = $_POST['max_capacity'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];

    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        $response = ["status" => "error", "message" => "Invalid CSRF token."];
        echo json_encode($response);
    }
    // Validation
    if (empty($eventId) || empty($maxCapacity) || empty($full_name) || empty($email) || empty($phone_number)) {
        echo "All fields are required!";
        exit;
    }


    $attendee = new AttendeeClass($db);

    $response = $attendee->registerAttendee($eventId, $maxCapacity, $full_name, $email, $phone_number);

    echo json_encode($response);
    exit;
}
