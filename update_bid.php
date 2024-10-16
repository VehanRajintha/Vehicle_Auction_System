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

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract bid_id and new_amount
    $bidId = $data['bid_id'];
    $newAmount = $data['new_amount'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE bids SET bid_amount = ? WHERE id = ?");
    $stmt->bind_param("di", $newAmount, $bidId);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>