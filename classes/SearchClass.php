<?php

class SearchClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function searchEventsAndAttendees($searchTerm)
    {
        try {
            $searchTerm = '%' . $searchTerm . '%';
            $query = "SELECT events.id, events.name, events.description, events.location, events.date, events.time, events.max_capacity, events.status, events.created_at, attendees.full_name AS attendee_name, attendees.email, attendees.phone, attendees.registered_at 
                  FROM events 
                  LEFT JOIN attendees ON events.id = attendees.event_id 
                  WHERE events.name LIKE :searchTerm OR attendees.full_name LIKE :searchTerm OR attendees.email LIKE :searchTerm OR attendees.phone LIKE :searchTerm";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
}
