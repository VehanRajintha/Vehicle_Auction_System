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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mnumber = $_POST['mnumber'];
    $password = $_POST['password'];

    // Handle file upload
    $profilepic = $_FILES['profilepic']['name'];
    $target_dir = "uploads/";
    
    // Check if the uploads directory exists, if not create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($profilepic);
    if (move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO users (username, email, mnumber, profilepic, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $email, $mnumber, $target_file, $password);

        if ($stmt->execute()) {
            header("Location: login.php?message=Registration successful");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

$conn->close();
?>