<?php
session_start();
require_once('../Controller/UserController.php');
require_once('../../validation/regex_patterns.php');
require_once('../../config/DbConnection.php');
require_once('../Model/User.php');

class UserController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($username, $email, $password, $confirmPassword)
{
    $mediumRegex = '/((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))/';
    $strongRegex = '/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/';
    $user = new User(null, $username, $email, $password);
    if ($user->isUsernameTaken($this->conn, $username)) {
        $_SESSION['error'] = "Username đã tồn tại. Vui lòng chọn username khác.";
        header('Location: loginRegister.php'); // Redirect to login page
        exit();
    } elseif ($user->isEmailTaken($this->conn, $email)) {
        $_SESSION['error'] = "Email đã được sử dụng. Vui lòng chọn email khác.";
        header('Location: loginRegister.php'); // Redirect to login page
        exit();
    } elseif (!preg_match($strongRegex, $password) && !preg_match($mediumRegex, $password)) {
        $_SESSION['error'] = "Mật khẩu yếu. Vui lòng chọn mật khẩu mạnh hơn.";
        header('Location: loginRegister.php'); // Redirect to login page
        exit();
    } elseif ($password !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu và mật khẩu xác nhận không khớp";
        header('Location: loginRegister.php'); 
        exit();
    } else {
        $user->hashPassword();
        $result = $this->insertUser($user);

        if ($result) {
            return "success";
        } else {
            $_SESSION['error'] = "Đã có lỗi xảy ra trong quá trình đăng ký.";
            header('Location: loginRegister.php');
            exit();
        }
    }
}

public function loginUser($identifier, $password)
{
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $user = $this->getUserByEmail($identifier);
    } else {
        $user = $this->getUserByUsername($identifier);
    }

    if ($user && $user->verifyPassword($password)) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        return "success";
    } else {
        return "Email hoặc tên đăng nhập và mật khẩu không chính xác.";
    }
}


    private function insertUser($user)
    {
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $user->getEmail(), $user->getUsername(), $user->getPassword());
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    private function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die("Error in prepared statement: " . $this->conn->error);
        }
    
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        if ($stmt->error) {
            die("Error executing statement: " . $stmt->error);
        }
    
        $result = $stmt->get_result();
    
        if (!$result) {
            die("Error getting result: " . $this->conn->error);
        }
    
        $row = $result->fetch_assoc();
    
        if ($row === null) {
            $stmt->close();
            return null;
        }
    
        $user = new User($row['id'], $row['username'], $row['email'], $row['password']);
    
        $stmt->close();
    
        return $user;
    }
    
    private function getUserByUsername($username)
{
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("Error in prepared statement: " . $this->conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    if ($stmt->error) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if (!$result) {
        die("Error getting result: " . $this->conn->error);
    }

    $row = $result->fetch_assoc();

    if ($row === null) {
        $stmt->close();
        return null;
    }

    $user = new User($row['id'], $row['username'], $row['email'], $row['password']);

    $stmt->close();

    return $user;
}

    
}

?>
