<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "vehicle_auction";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        sendJsonResponse("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $title = $_POST['title'];
    $starting_bid = $_POST['starting_bid'];
    $email = $_POST['email'];
    $image = $_FILES['image'];

    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Helper function to send JSON responses
    function sendJsonResponse($message) {
        echo json_encode([ 'message' => $message]);
        exit;
    }

    // Check if image file is a actual image or fake image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        sendJsonResponse("File is not an image.");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        sendJsonResponse("File already exists.");
    }

    // Check file size
    if ($image["size"] > 5000000) {
        sendJsonResponse("File is too large.");
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        sendJsonResponse("Invalid file format.");
    }

    // Try to move the uploaded file
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        sendJsonResponse("Sorry, there was an error uploading your file.");
    }

    // Insert data into the database
    $sql = "INSERT INTO auctions (title, image_url, current_bid, email) VALUES ('$title', '$target_file', '$starting_bid', '$email')";
    if (mysqli_query($conn, $sql)) {
        sendJsonResponse("Auction posted successfully.", 'success');
    } else {
       
    }
}
