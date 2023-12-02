<?php
$servername = "localhost";
$username = "root";
$password = "";

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
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$dbname = "ecommerce";

$result = $conn->query("SHOW DATABASES LIKE '$dbname'");

if ($result->num_rows == 0) {
    $sqlCreateDb = "CREATE DATABASE $dbname";

    if ($conn->query($sqlCreateDb) === TRUE) {
        echo "Cơ sở dữ liệu được tạo.\n";
    } else {
        echo "Lỗi tạo cơ sở dữ liệu: " . $conn->error . "\n";
    }
}

$conn->select_db($dbname);

$result = $conn->query("SHOW TABLES LIKE 'users'");

if ($result->num_rows == 0) {
    $sqlCreateUsersTable = "CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(10) NOT NULL UNIQUE,
        email VARCHAR(30) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        createDate DATE DEFAULT (CURRENT_DATE) 
    )";

    if ($conn->query($sqlCreateUsersTable) === TRUE) {
        $sqlInsertAdmin = "INSERT INTO users (username, email, password) VALUES
        ('Admin', 'admin@gmail.com', '" . password_hash('aDmIn.132', PASSWORD_DEFAULT) . "')";
        $conn->query($sqlInsertAdmin);
    } else {
        echo "Lỗi tạo bảng users: " . $conn->error . "\n";
    }
}

$result = $conn->query("SHOW TABLES LIKE 'user_details'");

if ($result->num_rows == 0) {
    $sqlCreateUserDetailsTable = "CREATE TABLE user_details (
        user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        avatar NVARCHAR(50),    
        firstName NVARCHAR(15),
        lastName NVARCHAR(10),
        phoneNumber CHAR(12),
        city NVARCHAR(20),
        district NVARCHAR(30),
        ward NVARCHAR(30),
        address NVARCHAR(40),
        FOREIGN KEY (user_id) REFERENCES users (id)
    )";

    if ($conn->query($sqlCreateUserDetailsTable) === TRUE) {
        echo "Bảng user_details được tạo.\n";
    } else {
        echo "Lỗi tạo bảng user_details: " . $conn->error . "\n";
    }
}

$result = $conn->query("SHOW TABLES LIKE 'permissions'");

if ($result->num_rows == 0) {
    $sqlCreatePermissionsTable = "CREATE TABLE permissions (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        permissionName NVARCHAR(15)
    )";
    if ($conn->query($sqlCreatePermissionsTable) === TRUE) {
        $sqlInsertPermission = "    INSERT INTO permissions (permissionName) VALUES
        ('admin'),
        ('user')";
        $conn->query($sqlInsertPermission);
    } else {
        echo "Lỗi tạo bảng permissions: " . $conn->error . "\n";
    }
}
$result = $conn->query("SHOW TABLES LIKE 'userPermission'");

if ($result->num_rows == 0) {
    $sqlCreateuserPermissionTable = "CREATE TABLE userPermission (
        userId INT(6) UNSIGNED,
        permissionId INT(6) UNSIGNED,
        FOREIGN KEY (userId) REFERENCES users (id),
        FOREIGN KEY (permissionId) REFERENCES permissions (id),
        PRIMARY KEY (userId, permissionId)
    )";

    if ($conn->query($sqlCreateuserPermissionTable) === TRUE) {
        $sqlInsertAdminPermission = "INSERT INTO userPermission VALUES
        (1, 1)";
        $conn->query($sqlInsertAdminPermission);
    } else {
        echo "Lỗi tạo bảng userPermission: " . $conn->error . "\n";
    }
}
?>