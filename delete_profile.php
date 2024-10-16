<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "vehicle_auction";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$response = array();

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Delete the user from the database
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        // Destroy the session to log out the user
        session_destroy();
    } else {
        $response['success'] = false;
        $response['error'] = $stmt->error;
    }

    $stmt->close();
} else {
    $response['success'] = false;
    $response['error'] = 'User ID not provided';
}

// Set the content type to JSON and return the response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>