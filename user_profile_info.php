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
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $mnumber = $_POST['mnumber'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['password']; // Do not hash the password

    // Check if the current password matches the database password
    if ($current_password === $user['password']) {
        // Update user details in the database
        $sql = "UPDATE users SET username='$username', mnumber='$mnumber', password='$new_password' WHERE email='$email'";
        if (mysqli_query($conn, $sql)) {
            $update_message = "Profile updated successfully.";
        } else {
            $update_message = "Error updating profile: " . mysqli_error($conn);
        }
    } else {
        $update_message = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        .profile-section {
        max-width: 800px;
        margin: 40px auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
        .profile-section:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

        .profile-section h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-container {
            text-align: center;
        }

        .profile-container p {
            font-size: 18px;
            margin: 10px 0;
        }

        .profile-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .profile-container button:hover {
            background-color: #45a049;
        }

        .edit-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .edit-popup-content {
            margin-top: 250px;
            margin-left: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="user_profile.php">Home</a></li>
                <li><a href="http://localhost/Auction_System/search.php?query=">Auctions</a></li>
                <li><a href="post_auction.php">Post Auction</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <div class="profile-pic-container" style="text-align: center; margin-bottom: 20px;">
    <img src="<?php echo $user['profilepic']; ?>" alt="Profile Picture" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
</div>
<section class="profile-section">
    <h1>User Profile</h1>
    <div class="profile-container">
        <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Mobile Number:</strong> <?php echo $user['mnumber']; ?></p>
        <button onclick="openEditPopup()">Edit Profile</button>
        <button onclick="deleteProfile()" style="background-color: #dc3545; color: white;">Delete Profile</button>
    </div>
</section>
    </main>
    

    <div id="edit-popup" class="edit-popup">
        <div class="edit-popup-content">
            <span onclick="closeEditPopup()" class="close-btn">&times;</span>
            <form id="edit-profile-form" method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="mnumber">Mobile Number:</label>
                    <input type="text" id="mnumber" name="mnumber" value="<?php echo $user['mnumber']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <?php if (isset($update_message)): ?>
        <div class="notification" id="notification"><?php echo $update_message; ?></div>
        <script>
            const notification = document.getElementById('notification');
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
                location.reload();
            }, 5000);
        </script>
    <?php endif; ?>

    <script>
    function openEditPopup() {
        document.getElementById('edit-popup').style.display = 'block';
    }

    function closeEditPopup() {
        document.getElementById('edit-popup').style.display = 'none';
    }
    </script>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('header', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('nav ul li', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
        ScrollReveal().reveal('.profile-pic-container', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('.profile-section h1', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.profile-container p', { duration: 1000, origin: 'right', distance: '50px', interval: 200 });
        ScrollReveal().reveal('.profile-container button', { duration: 1000, origin: 'bottom', distance: '50px', delay: 400 });
        ScrollReveal().reveal('.edit-popup', { duration: 1000, origin: 'top', distance: '50px' });
    </script>
    <script>
        function deleteProfile() {
    if (confirm('Are you sure you want to delete your profile? This action cannot be undone.')) {
        $.post('delete_profile.php', { userId: <?php echo $user['id']; ?> }, function(response) {
            // Log the response from the server for debugging
            console.log('Server Response:', response);
            
            if (response.success) {
                window.location.href = 'index.php';
            } else {
                alert('Failed to delete profile: ' + response.error);
            }
        }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
            // Log any errors for debugging
            console.error('Error:', textStatus, errorThrown);
            alert('Failed to delete profile due to an error: ' + textStatus + ' - ' + errorThrown);
        });
    }
}
    </script>
</html>

<?php
mysqli_close($conn);
?>