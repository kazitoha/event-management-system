<?php
header('Content-Type: application/json'); // Ensure JSON response
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests

require_once '../autoload.php'; // Include Event class

$event = new EventClass($db);

// Get API action
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        $events = $event->getAllEvent(); // Fetch events
        echo json_encode(['status' => 'success', 'data' => $events]);
        break;

    case 'view':
        $eventId = $_GET['id'] ?? null;
        if (!$eventId) {
            echo json_encode(['status' => 'error', 'message' => 'Event ID required']);
            exit;
        }
        $eventData = $event->getEventById($eventId);
        echo json_encode(['status' => 'success', 'data' => $eventData]);
        break;


    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}
