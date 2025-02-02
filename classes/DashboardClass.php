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
        try {
            $query = "SELECT COUNT(*) AS total FROM `events`";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
    public function getTotalAttendee()
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM `attendees`";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
    public function getActiveEvent()
    {
        try {
            $query = "SELECT name, description,  location, date, 
                    (SELECT count(*) FROM `events` WHERE `status` = 1) AS total
                  FROM `events`
                  WHERE `status` = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }



    public function getInactiveEvent()
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM `events` WHERE `status` = 0";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
}
