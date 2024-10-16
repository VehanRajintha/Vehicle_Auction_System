<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Auction</title>
    <link rel="stylesheet" href="css/post.css">
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
    <style>
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
                <li><a href="user_profile_info.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="post-auction-section">
            <div class="form-container">
                <h1>Post Your Auction</h1>
                <form id="post-auction-form" method="POST" action="post_auction.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="starting_bid">Starting Bid:</label>
                        <input type="number" id="starting_bid" name="starting_bid" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Image:</label>
                        <input type="file" id="image" name="image" accept="image/*" required
                            onchange="previewImage(event)">
                    </div>
                    <button type="submit" class="submit-btn">Post Auction</button>
                </form>
            </div>
            <div class="image-preview-container">
                <img id="image-preview" src="#" alt="Image Preview" style="display: none;">
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Auction System. All rights reserved.</p>
    </footer>

    <div class="notification" id="notification">Auction posted successfully!</div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('post-auction-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('submit_auction.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notification = document.getElementById('notification');
                        notification.style.display = 'block';
                        setTimeout(() => {
                            notification.style.display = 'none';
                            window.location.href = 'user_profile.php';
                        }, 5000);
                    } else {
                        alert('!' + data.message);
                        window.location.href = 'user_profile.php';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('footer p', { duration: 1000, origin: 'bottom', distance: '50px' });
        ScrollReveal().reveal('.notification', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('#post-auction-form', { duration: 1000, origin: 'left', distance: '50px' });
        
    </script>

</body>

</html>