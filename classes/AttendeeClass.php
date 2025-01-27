<?php
class AttendeeClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkEventDetails($event_id)
    {
        $status = 1;
        $query = "SELECT * FROM `events` WHERE `status` = :status AND  `id`=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerAttendee($eventId, $maxCapacity, $full_name, $email, $phone_number)
    {

        // Check for duplicate    
        $query = "SELECT COUNT(*) FROM attendees WHERE email = :email OR phone = :phone_number";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        // Decode eventId
        $eventId = decode($eventId);
        $totalAttendees = $this->sumTotalAttendee($eventId);

        // Check if the max capacity has been reached
        if ($totalAttendees >= $maxCapacity) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        if ($count > 0) {
            $_SESSION['error_msg'] = "User with this email or phone number already exists.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }




        $query = "INSERT INTO attendees (event_id, full_name, email,phone) VALUES (:event_id, :full_name, :email,:phone)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone_number, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Thank you for registering, $full_name. We look forward to seeing you at the event.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "done";
            exit;
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
            // Log the error or handle it as needed
            error_log("Database Error: " . $e->getMessage());
            return false; // Return false on failure
        }
    }
}
