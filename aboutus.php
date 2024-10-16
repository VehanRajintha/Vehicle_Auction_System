<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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

        .about-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .about-section h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 1.2em;
            color: #555;
            line-height: 1.6;
        }

        .faq-section {
            margin-top: 40px;
        }

        .faq-section h2 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }

        .faq-item {
            margin-bottom: 20px;
        }

        .faq-question {
            font-size: 1.2em;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .faq-question:hover {
            background-color: #45a049;
        }

        .faq-answer {
            display: none;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #4CAF50;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <header>
    <h1>About AuctionPro</h1>
    </header>

    <main>
        <section class="about-section">
            <h2>Welcome to AuctionPro</h2>
            <p>We are dedicated to providing the best vehicle auction services in the industry. Our team is composed of highly skilled professionals who are passionate about what they do. We believe in innovation, integrity, and excellence.</p>
        </section>

        <section class="faq-section">
            <h2>Frequently Asked Questions</h2>

            <div class="faq-item">
                <div class="faq-question">What services do you offer?</div>
                <div class="faq-answer">We offer a wide range of vehicle auction services, including online and in-person auctions for cars, trucks, and other vehicles.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">How can I contact you?</div>
                <div class="faq-answer">You can contact us via email at contact@auctionpro.com or call us at (123) 456-7890.</div>
            </div>

            <div class="faq-item">
                <div class="faq-question">Where are you located?</div>
                <div class="faq-answer">We are located at 123 Main Street, Anytown, USA.</div>
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll('.faq-question').forEach(item => {
            item.addEventListener('click', () => {
                const answer = item.nextElementSibling;
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });
    </script>
    <script>
        // Initialize ScrollReveal
        ScrollReveal().reveal('header h1', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.about-section h2', { duration: 1000, origin: 'left', distance: '50px' });
        ScrollReveal().reveal('.about-section p', { duration: 1000, origin: 'right', distance: '50px', delay: 200 });
        ScrollReveal().reveal('.faq-section h2', { duration: 1000, origin: 'top', distance: '50px' });
        ScrollReveal().reveal('.faq-item', { duration: 1000, origin: 'bottom', distance: '50px', interval: 200 });
    </script>
</body>
</html>