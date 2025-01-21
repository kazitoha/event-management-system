<?php
class Attendee
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function registerAttendee($event_id, $name, $email)
    {
        $query = "INSERT INTO attendees (event_id, name, email) VALUES (:event_id, :name, :email)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
