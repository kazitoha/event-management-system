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
        try {
            $status = 1;
            $query = "SELECT * FROM `events` WHERE `status` = :status AND  `id`=:id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function registerAttendee($eventId, $maxCapacity, $full_name, $email, $phone_number)
    {
        try {

            $eventId = decode($eventId);

            // Check for duplicate
            $query = "SELECT COUNT(*) FROM attendees WHERE event_id = :eventId AND (email = :email OR phone = :phone_number)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            $maxCapacity = decode($maxCapacity);
            $totalAttendees = $this->sumTotalAttendee($eventId);


            // Check max capacity
            if ($totalAttendees >= $maxCapacity) {
                return ["status" => "error", "message" => "Registration failed! The event has reached its maximum capacity."];
            }

            // Check for duplicate attendee
            if ($count > 0) {
                return ["status" => "error", "message" => "User with this email or phone number already exists."];
            }

            // Insert into attendees table
            $query = "INSERT INTO attendees (event_id, full_name, email, phone) VALUES (:event_id, :full_name, :email, :phone)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->bindParam(':full_name', $full_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone_number, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return ["status" => "success", "message" => "Attendee registered successfully!"];
            } else {
                return ["status" => "error", "message" => "Error while registering attendee."];
            }
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            return  $e->getMessage(); // Return false on failure
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
