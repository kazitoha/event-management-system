<?php
class UserClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $email, $password, $confirm_password)
    {

        // Check for empty fields
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error_msg'] = "All fields are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Check if passwords match
        if ($password !== $confirm_password) {
            $_SESSION['error_msg'] = "Passwords do not match.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }



        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_msg'] = "Invalid email format.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }



        try {
            // Check for duplicate email
            $query = "SELECT COUNT(*) FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['error_msg'] = "User with this email already exists.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "User successfully registered.";
            } else {
                $_SESSION['error_msg'] = "An error occurred while registering. Please try again.";
            }
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function updateUser($userId, $username, $email, $password, $confirm_password)
    {
        // Check for empty fields
        if (empty($username) || empty($email)) {
            $_SESSION['error_msg'] = "Username and email are required.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Check if passwords match (only if password is provided)
        if (!empty($password) && $password !== $confirm_password) {
            $_SESSION['error_msg'] = "Passwords do not match.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        try {
            // Check for duplicate email (excluding the current user)
            $query = "SELECT COUNT(*) FROM users WHERE email = :email AND id != :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['error_msg'] = "Email is already taken.";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            }

            // Update user information
            $query = "UPDATE users SET username = :username, email = :email";

            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query .= ", password = :password";
            }

            $query .= " WHERE id = :userId";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

            if (!empty($password)) {
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "User data updated successfully.";
            } else {
                $_SESSION['error_msg'] = "Failed to update user data.";
            }
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Database error: " . $e->getMessage();
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
    function deleteUser($id)
    {
        $id = decode($id);
        $active_user_id = decode($_SESSION['user_id']);

        if ($id == $active_user_id) {
            $_SESSION['error_msg'] = "User id can't be delete because it's you.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }

        $query = "DELETE FROM `users` WHERE id=:id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "User deleted successfully.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $_SESSION['error_msg'] = "Failed to update user data.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
