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
    header("Location: http://localhost/Auction_System/login.php");
    exit();
}

// Retrieve the email from the session
$email = $_SESSION['email'];

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $bid_id = $data['bid_id'];
    $new_amount = $data['new_amount'];

    // Prepare the SQL query to update the bid amount
    $query = "UPDATE bids SET bid_amount = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('di', $new_amount, $bid_id);

    // Execute the query and prepare the response
    $response = [];
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }

    // Send the response as JSON
    echo json_encode($response);
    exit;
}

// Query the database to get the username and profile picture
$query = "SELECT username, profilepic FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = $user['username'];
$profilePic = $user['profilepic'];

// Fetch user's bids
$sql = "SELECT bid_amount, vehicle_name, created_at FROM bids WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$bids = [];
while ($row = $result->fetch_assoc()) {
    $bids[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2015 Ford Mustang - Bidding Page</title>
    <link rel="stylesheet" href="css/bids.css">

    <style>
        .welcome-section {
            position: absolute;
            top: 0px;
            /* Adjusted to account for the navbar */
            left: 850px;
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

        <style>body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        .left-side {
            flex: 3;
            /* Ensure this takes up more space */
            padding-right: 20px;
            height: 80vh;
            /* Ensure it takes the full viewport height */
        }

        .left-side iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .right-side {
            flex: 2;
            justify-content: center;
            /* Decreased from 2 to 1 */
        }

        .bids-container {
            width: 100%;
        }

        .bid-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        .bid-item:hover {
            background-color: #f9f9f9;
        }

        .bid-item:last-child {
            border-bottom: none;
        }

        .bid-amount {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .vehicle-name {
            font-size: 16px;
            color: #555;
        }

        .created-at {
            font-size: 14px;
            color: #999;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Add this to your CSS file */
        .edit-amount-btn {
            background-color: #4CAF50;
            /* Green background */
            border: none;
            /* Remove borders */
            color: white;
            /* White text */
            padding: 10px 20px;
            /* Some padding */
            text-align: center;
            /* Center the text */
            text-decoration: none;
            /* Remove underline */
            display: inline-block;
            /* Make the button inline-block */
            font-size: 16px;
            /* Increase font size */
            margin: 4px 2px;
            /* Some margin */
            cursor: pointer;
            /* Pointer/hand icon */
            border-radius: 12px;
            /* Rounded corners */
            transition: background-color 0.3s;
            /* Smooth transition */
        }

        .edit-amount-btn:hover {
            background-color: #45a049;
            /* Darker green on hover */
        }

        /* Modal styles */
        #editAmountModal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1000;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5);
            /* Black w/ opacity */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            position: fixed;
            /* Fixed position to center it */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Center it */
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        .close-btn {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
        }

        .modal-content h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
        }

        .modal-content label {
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        .modal-content input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .modal-content button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            /* Green background */
            color: white;
            /* White text */
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .notification.show {
            opacity: 1;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">AuctionPro</div>
            <ul>
                <li><a href="http://localhost/Auction_System/user_profile.php#home">Home</a></li>
                <li><a href="user_profile_info.php">Profile</a></li>
                <li><a href="#">My bids</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="welcome-section">
        <div class="profile-container">
            <div class="welcome-message">Welcome, <?php echo $username; ?>!</div>
            <iframe src="https://lottie.host/embed/02cbc03e-d8ad-4e58-af0d-49d7943c68ea/osDEC71fov.json"
                class="welcome-iframe"></iframe>
        </div>
    </div>

    <div class="container">
        <div class="left-side">
            <iframe src="https://lottie.host/embed/7e25f46f-0172-460a-9adc-aa5476ca29cd/imkjX2wG1N.json"
                style="width: 100%; height: 100%; border: none;"></iframe>
        </div>
        <div class="right-side">
            <section class="bids-container">
                <h2>Your Bids</h2>
                <?php if (empty($bids)): ?>
                    <p>No bids found.</p>
                <?php else: ?>
                    <?php foreach ($bids as $bid): ?>
                        <div class="bid-item">
                            <div class="bid-amount">Bid Amount: $<?php echo number_format($bid['bid_amount'], 2); ?></div>
                            <div class="vehicle-name">Vehicle: <?php echo htmlspecialchars($bid['vehicle_name']); ?></div>
                            <div class="created-at">Placed on:
                                <?php echo date('F j, Y, g:i a', strtotime($bid['created_at'])); ?>
                            </div>
                            <button class="edit-amount-btn" data-bid-id="<?php echo $bid['id']; ?>">Edit Amount</button>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 AuctionPro. All rights reserved.</p>
    </footer>

    <!-- Modal Popup -->
    <div id="editAmountModal" style="display:none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Edit Bid Amount</h2>
            <form id="editAmountForm">
                <input type="hidden" name="bid_id" id="bid_id">
                <label for="new_amount">New Amount:</label>
                <input type="number" name="new_amount" id="new_amount" step="0.01" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-amount-btn');
            const modal = document.getElementById('editAmountModal');
            const closeModalBtn = document.querySelector('.close-btn');
            const editForm = document.getElementById('editAmountForm');
            const bidIdInput = document.getElementById('bid_id');
            const newAmountInput = document.getElementById('new_amount');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const bidId = this.getAttribute('data-bid-id');
                    bidIdInput.value = bidId;
                    modal.style.display = 'block';
                });
            });

            closeModalBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            editForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const bidId = bidIdInput.value;
                const newAmount = newAmountInput.value;

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ bid_id: bidId, new_amount: newAmount })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Bid amount updated');
                            location.reload();
                        } else {
                            showNotification('Failed to update bid amount', true);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred', true);
                    });
            });

            function showNotification(message, isError = false) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                if (isError) {
                    notification.style.backgroundColor = '#f44336'; // Red background for errors
                }
                notification.textContent = message;
                document.body.appendChild(notification);

                // Show the notification
                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);

                // Hide the notification after 3 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    notification.classList.add('hide');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            }
        });
    </script>
</body>

</html>