<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

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

$email = $_SESSION['email'];
$query = "SELECT * FROM auctions WHERE email = '$email'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Auctions</title>
    <link rel="stylesheet" href="css/user_auctions.css">
    <script>
        function openEditModal(id, title, currentBid, imageUrl) {
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('auctionId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editCurrentBid').value = currentBid;
            document.getElementById('editImageUrl').value = imageUrl;
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="user_profile.php">Home</a></li>
                <li><a href="auctions.php">Auctions</a></li>
                <li><a href="post_auction.php">Post Auction</a></li>
                <li><a href="user_profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="auctions-section">
            <h1>My Auctions</h1>
            <div class="auctions-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='auction-card'>";
                        echo "<img src='" . $row['image_url'] . "' alt='Auction Image'>";
                        echo "<h2>" . $row['title'] . "</h2>";
                        echo "<p>Current Bid: $" . $row['current_bid'] . "</p>";
                        echo "<button style='background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-right: 10px;' onclick=\"openEditModal('" . $row['id'] . "', '" . $row['title'] . "', '" . $row['current_bid'] . "', '" . $row['image_url'] . "')\">Edit</button>";
                        echo "<form method='POST' action='delete_auction.php' style='display:inline;'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' style='background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;'>Delete</button>";
                        echo "</form>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No auctions found.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <div id="editModal"
        style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
        <div
            style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);">
            <span style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;"
                onclick="closeEditModal()">&times;</span>
            <form method="POST" action="edit_auction.php">
                <input type="hidden" id="auctionId" name="id">
                <div style="margin-bottom: 15px;">
                    <label for="editTitle">Title:</label>
                    <input type="text" id="editTitle" name="title"
                        style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="editCurrentBid">Current Bid:</label>
                    <input type="text" id="editCurrentBid" name="current_bid"
                        style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                
                <div style="text-align: right;">
                    <button type="submit"
                        style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Save</button>
                    <button type="button"
                        style="background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;"
                        onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Auction System. All rights reserved.</p>
    </footer>
</body>

</html>

<?php
mysqli_close($conn);
?>