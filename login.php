<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
        .container {
            perspective: 1000px;
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.2);
            /* Transparent background */
            backdrop-filter: blur(10px);
            /* Blur effect */
            border-radius: 10px;
            /* Optional: rounded corners */
            padding: 20px;
            /* Optional: padding inside the container */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Optional: subtle shadow */
        }

        .card {
            width: 500px;
            height: 550px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            z-index: 2;
        }


        .inner-box {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
        }

        .card-back {
            transform: rotateY(180deg);
        }

        .flipped {
            transform: rotateY(180deg);
        }

        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .notification {
            padding: 15px;
            background-color: #f44336;
            /* Red */
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
            animation: fadeIn 1s ease-in-out;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            /* Ensure it appears above other elements */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <video autoplay muted loop class="background-video">
        <source src="images/video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container glass-effect">
        
        <div class="card" id="card">
            <div class="inner-box card-front">
                <h2>Login</h2>
                <form id="login-form" method="POST" action="login_handler.php">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
                <button type="button" onclick="openRegister()">Sign Up</button>
            </div>
            <div class="inner-box card-back">
                <h2>Sign Up</h2>
                <form id="register-form" method="POST" action="register_handler.php" enctype="multipart/form-data">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="mnumber" placeholder="Phone Number" required>
                    <input type="file" name="profilepic" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign Up</button>
                </form>
                <button type="button" onclick="openLogin()">Login</button>
            </div>
        </div>
    </div>
    <script>
        function openRegister() {
            document.getElementById('card').classList.add('flipped');
        }

        function openLogin() {
            document.getElementById('card').classList.remove('flipped');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var urlParams = new URLSearchParams(window.location.search);
            var message = urlParams.get('message');
            if (message) {
                var notification = document.createElement('div');
                notification.innerText = message;
                notification.style.position = 'fixed';
                notification.style.top = '20px';
                notification.style.right = '20px';
                notification.style.backgroundColor = '#f44336'; // Red
                notification.style.color = 'white';
                notification.style.padding = '15px';
                notification.style.borderRadius = '5px';
                notification.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.2)';
                document.body.appendChild(notification);
                setTimeout(function () {
                    notification.remove();
                }, 5000); // Remove notification after 5 seconds
            }
        });
    </script>
</body>

</html>