<?php

class Event
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Create a new event
     */
    public function createEvent($name, $date, $location, $description, $max_capacity)
    {

        // Check for empty fields
        if (empty($name) || empty($date) || empty($location) || empty($description) || empty($max_capacity)) {
            $_SESSION['error_msg'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        try {


            // Insert the event into the database
            $query = "INSERT INTO events (name, date, location, description, max_capacity) 
                      VALUES (:name, :date, :location, :description, :max_capacity)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':max_capacity', $max_capacity, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Event created successfully.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $_SESSION['error_msg'] = "Failed to create event.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Get event details by ID
     */
    public function getEventById($eventId)
    {
        try {
            $query = "SELECT * FROM events WHERE id = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Update an event
     */

    public function updateEvent($eventId, $name, $date, $location, $description, $max_capacity)
    {

        // Check for empty fields
        if (empty($name) || empty($date) || empty($location) || empty($max_capacity)) {
            $_SESSION['error_msg'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        try {
            $query = "UPDATE events SET 
                      name = :name, 
                      date = :date, 
                      location = :location, 
                      description = :description, 
                      max_capacity = :max_capacity 
                      WHERE id = :eventId";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':max_capacity', $max_capacity, PDO::PARAM_INT);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Event updated successfully.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $_SESSION['error_msg'] = "Failed to update event.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Delete an event
     */
    public function deleteEvent($eventId)
    {
        try {
            $query = "DELETE FROM events WHERE id = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Event deleted successfully.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $_SESSION['error_msg'] = "Failed to delete event.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    /**
     * Get all events
     */
    public function getAllEvents()
    {
        try {
            $query = "SELECT * FROM events ORDER BY date ASC";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
