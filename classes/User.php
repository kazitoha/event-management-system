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
            $_SESSION['logged_in'] = true;
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
            $_SESSION['logged_in'] = true;
            header("Location: ?page=dashboard");
            exit();
        } else {
            header("Location: ?page=login&error=user_not_exist");
            exit();
        }
    }
}
