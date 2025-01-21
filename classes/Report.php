<?php
class Report
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function generateReport($event_id)
    {
        $query = "SELECT * FROM attendees WHERE event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();
        $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filename = "event_{$event_id}_report.csv";
        $file = fopen($filename, 'w');
        fputcsv($file, ['ID', 'Name', 'Email']);

        foreach ($attendees as $attendee) {
            fputcsv($file, $attendee);
        }
        fclose($file);
        return $filename;
    }
}
