<?php

class DashboardClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTotalEvent()
    {
        $query = "SELECT COUNT(*) AS total FROM `events`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total']; // Return only the count
    }
    public function getTotalAttendee()
    {
        $query = "SELECT COUNT(*) AS total FROM `attendees`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total']; // Return only the count
    }
    public function getActiveEvent()
    {
        $query = "SELECT name, description,  location, date, 
                    (SELECT count(*) FROM `events` WHERE `status` = 1) AS total
                  FROM `events`
                  WHERE `status` = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows

        return $result; // Return all rows with the sum as 'total'
    }



    public function getInactiveEvent()
    {
        $query = "SELECT COUNT(*) AS total FROM `events` WHERE `status` = 0";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total']; // Return only the count
    }
}
