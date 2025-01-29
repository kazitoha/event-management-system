<?php
require '../../../autoload.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header(header: "Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

$report = new ReportClass($db);
$eventId = $_GET['event_id'] ?? 0; // Get event ID from URL parameter
$report->exportAttendeeReportCSV($eventId);
