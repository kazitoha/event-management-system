<?php

class EventClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Create a new event
     */
    public function createEvent($name, $description, $location, $date, $time, $max_capacity)
    {

        // Check for empty fields
        if (empty($name) || empty($date) || empty($location) || empty($description) || empty($max_capacity)) {
            $_SESSION['error_msg'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        try {
            // Insert the event into the database
            $query = "INSERT INTO events (name, date, location, description,time, max_capacity) 
                      VALUES (:name, :date, :location, :description,:time, :max_capacity)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':location', $location, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
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
     * Update an event
     */

    public function updateEvent($eventId, $name, $date, $location, $description, $max_capacity)
    {

        $eventId = decode($eventId);

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
    public function deleteEventWithAttendee($eventId)
    {
        try {
            $eventId = decode($eventId);
            // Delete from attendees table
            $query = "DELETE FROM `attendees` WHERE `event_id` = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            // Delete from events table
            $query = "DELETE FROM `events` WHERE `id` = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['success_msg'] = "Event and related attendees deleted successfully.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (PDOException $e) {
            // Roll back the transaction if there is an error
            $this->db->rollBack();
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function changeStatus($eventId, $status)
    {
        try {
            $eventId = decode($eventId);
            $status = decode($status);

            $query = "UPDATE `events` SET `status` = :status WHERE id = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Event status change successfully.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $_SESSION['error_msg'] = "Failed to change status.";
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
     * sum Total Attendee
     */
    public function sumTotalAttendee($eventId)
    {
        try {
            $query = "SELECT COUNT(*) FROM `attendees` WHERE `event_id` = :eventId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_STR);
            $stmt->execute();
            // Fetch the count from the query
            $totalAttendees = $stmt->fetchColumn();
            return $totalAttendees;
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            error_log("Database Error: " . $e->getMessage());
            return false; // Return false on failure
        }
    }
}
