<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - AuctionPro</title>
    <script src="https://unpkg.com/scrollreveal"></script> <!-- Include ScrollReveal.js -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        main {
            padding: 20px;
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .contact-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .contact-section h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .contact-section p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .contact-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #45a049;
        }

        .contact-details {
            margin-top: 40px;
            text-align: center;
        }

        .contact-details p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <header>
        <h1>Contact Us - AuctionPro</h1>
    </header>

    <main>
        <section class="contact-section">
            <h2>Get in Touch</h2>
            <p>If you have any questions or need further information, please feel free to contact us. Our team is here to assist you.</p>
        </section>

        <section class="contact-form-section">
            <form class="contact-form" id="contact-form" method="POST" action="">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </section>

        <section class="contact-details">
            <h2>Contact Information</h2>
            <p>Email: contact@auctionpro.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: 123 Main Street, Anytown, USA</p>
        </section>
    </main>

    <script>
        document.getElementById('contact-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('send_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert('Message sent successfully!');
                document.getElementById('contact-form').reset();
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
    <script>
    // Initialize ScrollReveal
    ScrollReveal().reveal('.contact-section h2', { duration: 1000, origin: 'top', distance: '50px' });
    ScrollReveal().reveal('.contact-section p', { duration: 1000, origin: 'bottom', distance: '50px', delay: 200 });
    ScrollReveal().reveal('.contact-form-section', { duration: 1000, origin: 'left', distance: '50px' });
    ScrollReveal().reveal('.contact-form input', { duration: 1000, origin: 'right', distance: '50px', interval: 200 });
    ScrollReveal().reveal('.contact-form textarea', { duration: 1000, origin: 'right', distance: '50px', delay: 600 });
    ScrollReveal().reveal('.contact-form button', { duration: 1000, origin: 'bottom', distance: '50px', delay: 800 });
    ScrollReveal().reveal('.contact-details h2', { duration: 1000, origin: 'top', distance: '50px' });
    ScrollReveal().reveal('.contact-details p', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
</script>
</body>
</html>