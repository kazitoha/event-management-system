<?php


function getAllEvents()
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
