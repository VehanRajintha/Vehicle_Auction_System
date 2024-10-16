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

$query = isset($_GET['query']) ? $_GET['query'] : '';

$sql = "SELECT * FROM auctions WHERE title LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $query . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <div class="logo">AuctionPro</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#auctions">Auctions</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="contactus.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <section id="search-results">
        <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
        <div class="results">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='auction-item' data-title='" . $row['title'] . "'>";
                    echo "<img src='" . $row['image_url'] . "' alt='Vehicle Image'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>Current Bid: $" . $row['current_bid'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2023 AuctionPro. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>