<?php
require_once('../../config/DbConnection.php');
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($inputPassword)
    {
        return password_verify($inputPassword, $this->password);
    }

    function getUserById($conn, $id) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?"); 
        $stmt->bind_param("", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    
    function isUsernameTaken($conn, $username)
    {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();
    
        return $count > 0;
    }
    
    function isEmailTaken($conn, $email)
    {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();
    
        return $count > 0;
    }
}
?>
