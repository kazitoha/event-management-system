<?php
class ReportClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAttendeeReport($eventId)
    {
        $query = "SELECT 
                    e.name,
                    a.full_name, 
                    a.email, 
                    a.phone, 
                    a.registered_at 
                  FROM attendees a
                  JOIN events e ON a.event_id = e.id
                  WHERE a.event_id = :eventId
                  ORDER BY a.id DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function exportAttendeeReportCSV($eventId)
    {
        $eventId = decode($eventId);

        $data = $this->getAttendeeReport($eventId);

        if (empty($data)) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $eventName = preg_replace("/[^a-zA-Z0-9]/", "_", $data[0]['name']);
        $now = date("Y-m-d H:i:s");
        $fileName = "{$eventName}_{$now}.csv";


        ob_clean();
        ob_start();


        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $output = fopen('php://output', 'w');


        fprintf($output, "\xEF\xBB\xBF");



        fputcsv($output, ["Event Name", "Full Name",  "Email", "Phone", "Registered At"]);


        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        ob_end_flush();
        exit;
    }
}
