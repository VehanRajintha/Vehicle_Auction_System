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

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Retrieve the email from the session
$email = $_SESSION['email'];

// Query the database to get the username and profile picture
$query = "SELECT username, profilepic FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$profilePic = $user['profilepic'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Auction System</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js" defer></script>
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
    <style>
        .welcome-section {
            position: absolute;
            top: 0px;
            /* Adjusted to account for the navbar */
            left: 10px;
            margin: 10px;
            width: 500px;
            height: 150px;
        }

        .profile-container {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border: 2px solid white;
            /* Added white outline */
        }

        .welcome-message {
            color: white;
            font-size: 19px;
            font-weight: bold;

        }

        .welcome-iframe {
            width: 50px;
            height: 50px;
            border: none;
        }

        .post-auction-container {
            position: absolute;
            top: 312px;
            right: 580px;
        }

        .post-auction-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            /* Green */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .post-auction-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo" style="margin-left: 800px;">
                AuctionPro
            </div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="user_profile_info.php">Profile</a></li>
                <li><a href="user_auctions.php">My Auctions</a></li>
                <li><a href="user_bids.php">My Bids</a></li>
                <li><a href="logout.php">Logout</a></li>

                <div class="welcome-section">

                </div>
            </ul>

        </nav>

    </header>
    <div class="welcome-section">
        <div class="profile-container">
            <img src="<?php echo $profilePic; ?>" alt="Profile Picture" class="profile-pic">
            <div class="welcome-message">Welcome, <?php echo $username; ?>!</div>
            <iframe src="https://lottie.host/embed/02cbc03e-d8ad-4e58-af0d-49d7943c68ea/osDEC71fov.json"
                class="welcome-iframe"></iframe>
        </div>
    </div>
    <section id="hero">
        <div class="hero-content">
            <h1>Find Your Dream Vehicle</h1>
            <p>Bid on the best vehicles from the comfort of your home</p>
            <form id="search-form" method="GET" action="search.php">
                <input type="text" name="query" placeholder="Search for vehicles...">
                <button type="submit">Search</button>
            </form>
        </div>
    </section>

    <!-- Post Auction Button -->
    <div class="post-auction-container">
        <a href="post_auction.php" class="post-auction-btn">Post Auction</a>
    </div>

    <section id="featured-auctions">
        <h2>Featured Auctions</h2>
        <div class="carousel">
            <?php
            // Assuming a connection to the database is already established
            $query = "SELECT * FROM auctions WHERE featured = 1";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='auction-item' data-title='" . $row['title'] . "'>";
                echo "<img src='" . $row['image_url'] . "' alt='Vehicle Image'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p>Current Bid: $" . $row['current_bid'] . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>

    <section id="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
            <div class="step">
                <h3>Step 1</h3>
                <p>Register an account</p>
            </div>
            <div class="step">
                <h3>Step 2</h3>
                <p>Browse auctions</p>
            </div>
            <div class="step">
                <h3>Step 3</h3>
                <p>Place your bid</p>
            </div>
            <div class="step">
                <h3>Step 4</h3>
                <p>Win and collect your vehicle</p>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <h2>Testimonials</h2>
        <div class="testimonials-container">
            <div class="testimonial">
                <p>"Great experience! I found my dream car at a great price."</p>
                <h4>- John Doe</h4>
            </div>
            <div class="testimonial">
                <p>"Easy to use and excellent customer service."</p>
                <h4>- Jane Smith</h4>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 AuctionPro. All rights reserved.</p>
    </footer>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('.logo', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('nav ul li', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
        ScrollReveal().reveal('.welcome-section', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.profile-container', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.profile-pic', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('.welcome-message', { duration: 1000, origin: 'right', distance: '50px' });
        ScrollReveal().reveal('.hero-content h1', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.hero-content p', { duration: 1000, origin: 'top', distance: '50px', delay: 200 });
        ScrollReveal().reveal('.search-form', { duration: 1000, origin: 'top', distance: '50px', delay: 400 });
        ScrollReveal().reveal('.post-auction-container', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.featured-auctions h2', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.carousel', { duration: 1000, origin: 'bottom', distance: '50px', delay: 200 });
        ScrollReveal().reveal('.hero', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.post-auction-container', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.featured-auctions', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('#testimonials h2', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.testimonials-container .testimonial', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
        ScrollReveal().reveal('footer p', { duration: 1000, origin: 'bottom', distance: '50px' });

    </script>
</body>

</html>