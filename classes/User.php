<?php
class User
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
            header("Location: ?page=register&error=empty_fields");
            exit();
        }

        // Check if passwords match
        if ($password != $confirm_password) {
            header("Location: ?page=register&error=password_mismatch");
            exit();
        }

        // Check for duplicate username or email
        $query = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            header("Location: ?page=register&error=user_exists");
            exit();
        }
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user
        $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {

            if (!$_SESSION['admin'] == true) {
                $_SESSION['user'] = true;
                $_SESSION['logged_in'] = true;
            }

            header("Location: ?page=dashboard");
            exit();
        } else {

            header("Location: ?page=register&error=insert_failed");
            exit();
        }
    }


    public function login($email, $password)
    {
        // Check for empty fields
        if (empty($email) || empty($password)) {
            header("Location: ?page=login&error=empty_fields");
            exit();
        }

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {

            if ($user['role'] == 'admin') {
                $_SESSION['admin'] = true;
                $_SESSION['logged_in'] = true;
            } else {
                $_SESSION['user'] = true;
                $_SESSION['logged_in'] = true;
            }

            header("Location: ?page=dashboard");
            exit();
        } else {
            header("Location: ?page=login&error=user_not_exist");
            exit();
        }
    }


    public function updateUser($userId, $username, $email, $role, $password, $confirm_password)
    {
        // Check for empty fields
        if (empty($username) || empty($email)) {
            header("Location: ?page=update_user&error=empty_fields");
            exit();
        }



        // Check if passwords match (only if password is provided)
        if (!empty($password) && $password != $confirm_password) {
            header("Location: ?page=user_management&error=password_mismatch");
            exit();
        }

        // Check for duplicate email (excluding the current user)
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 1) {
            // If email is already used by another user
            header("Location: ?page=user_management&error=email_taken");
            exit();
        }

        // Prepare the query for updating user information
        $query = "UPDATE users SET username = :username, email = :email, role = :role";

        // Only update password if a new one is provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :userId";

        // Prepare and bind parameters
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':userId', $userId);

        // Bind password only if it's being updated
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }

        // Execute the query and handle the result
        if ($stmt->execute()) {
            // Redirect on success
            header("Location: ?page=user_management&success=updated");
            exit();
        } else {
            // Redirect on failure
            header("Location: ?page=user_management&error=update_failed");
            exit();
        }
    }
}
