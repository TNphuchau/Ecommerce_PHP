<?php
require_once "./mvc/models/MyModels.php";
// Include your database connection script

$search = "%" . $_POST['search'] . "%";
$query = "SELECT * FROM products WHERE name LIKE ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    while ($row = $result->fetch_assoc()) {
        // Format each product as HTML
        $output .= '<div class="card">';
        $output .= '<p class="title">' . htmlspecialchars($row['name']) . '</p>';
        // Add more product details here as needed
        $output .= '</div>';
    }

    echo $output;
    $stmt->close();
} else {
    // Handle errors, e.g., statement preparation failed
}
