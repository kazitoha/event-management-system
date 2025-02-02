<?php

class EventClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


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
            echo "Connection Error: " . $e->getMessage();
        }
    }



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
            echo "Connection Error: " . $e->getMessage();
        }
    }


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
            echo "Connection Error: " . $e->getMessage();
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
            echo "Connection Error: " . $e->getMessage();
        }
    }





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
            echo "Connection Error: " . $e->getMessage();
        }
    }

    public function getEventData($currentPage = 1, $perPage = 10, $sortBy = 'name', $sortOrder = 'ASC', $searchTerm = '', $statusFilter = '', $dateFilter = '')
    {
        try {
            $offset = ($currentPage - 1) * $perPage;

            // Validate sorting column
            $validColumns = ['name', 'location', 'date', 'max_capacity', 'status'];
            if (!in_array($sortBy, $validColumns)) {
                $sortBy = 'name';
            }
            $sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

            // Base query
            $query = "SELECT * FROM events WHERE (name LIKE :searchTerm OR location LIKE :searchTerm)";

            // Filtering by status if provided
            if ($statusFilter !== '') {
                $query .= " AND status = :statusFilter";
            }

            // Filtering by date if provided
            if ($dateFilter !== '') {
                $query .= " AND date = :dateFilter";
            }

            // Sorting and pagination
            $query .= " ORDER BY $sortBy $sortOrder LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($query);

            // Binding parameters
            $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            if ($statusFilter !== '') {
                $stmt->bindValue(':statusFilter', $statusFilter, PDO::PARAM_INT);
            }
            if ($dateFilter !== '') {
                $stmt->bindValue(':dateFilter', $dateFilter, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }



    public function getTotalEventRecords($searchTerm = '')
    {
        try {
            $searchTerm = '%' . $searchTerm . '%';

            $stmt = $this->db->prepare("SELECT COUNT(*) FROM events WHERE name LIKE :searchTerm OR location LIKE :searchTerm");
            $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }


    public function searchEventsAndAttendees($searchTerm)
    {
        try {
            $searchTerm = '%' . $searchTerm . '%';
            $query = "SELECT events.*, attendees.name AS attendee_name FROM events 
                  LEFT JOIN attendees ON events.id = attendees.event_id 
                  WHERE events.name LIKE :searchTerm OR attendees.name LIKE :searchTerm";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }

    // json api code start from here

    public function getAllEvent()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM events");
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all records

            if ($events) {
                return ['status' => 'success', 'data' => $events];
            } else {
                return ['status' => 'error', 'message' => 'No events found'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function getEventById($eventId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM events WHERE id = :eventId");
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($event) {
                return ['status' => 'success', 'data' => $event];
            } else {
                return ['status' => 'error', 'message' => 'Event not found'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}
