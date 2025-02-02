<?php
class LoginClass
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login($email, $password)
    {
        // Check for empty fields
        if (empty($email) || empty($password)) {
            $_SESSION['error_msg'] = "Email and password are required.";
            header("Location: ?page=login&error=empty_fields");
            exit();
        }
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = encode($user['id']);
                $_SESSION['logged_in'] = true;
                header("Location: ?page=dashboard");
                exit();
            } else {

                $_SESSION['error_msg'] = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        header("Location: ?page=login&error=user_not_exist");
        exit();
    }
}
