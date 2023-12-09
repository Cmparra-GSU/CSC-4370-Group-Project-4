<?php
session_start();
include '../functions/generalFunctions.php';

if (isset($_SESSION['login_error'])) {
    echo '<script>alert("' . $_SESSION['login_error'] . '");</script>';
    unset($_SESSION['login_error']); // Clear the error message
}

// Check for signup errors
if (isset($_SESSION['signup_error'])) {
    echo '<script>alert("' . $_SESSION['signup_error'] . '");</script>';
    unset($_SESSION['signup_error']); // Clear the error message
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Georgia Doors</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Playfair+Display:wght@400;700&family=Poiret+One&family=Tenor+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="logo-container">
            <div class="logo-text">
                <span class="peach-text">Georgia</span>
                <div class="about-icon"></div>
                <span class="peach-text">Doors</span>
            </div>
        </div>
    </header>

    <main>
        

        <div class="split">
            <div class="left-section">
                <!-- Image goes here -->
                <img src="atl.jpg" alt="Atlanta">
            </div>
            <div class="right-section">
                <!-- Text content goes here -->
                <h2> Welcome to Georgia Doors <br> Your Trusted Partner in Georgia Real Estate!
                </h2>
                <p>Georgia doors was established in 2023 with the goal of streamlining the home buying process. Our focus solely on the state of Georgia makes it easier
                    to provide a highly personalized experience tailored exclusively to Georgia home buyers and sellers. Whether you're moving in or out, our commitment 
                    is to equip you with the essential resources for a seamless home sale or purchase. Your home, your Georgia – we're here to make it all effortlessly yours."
                </p>
            </div>
        </div>

        <section id="user-action">
            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                // Check user role and redirect accordingly
                if ($_SESSION['user_role'] == 'buyer') {
                    echo '<button id="login-button" onclick="location.href=\'../user/buyerDash.php\'">Dashboard</button>';
                    echo '<button id="signup-button" onclick="location.href=\'logout.php\'">Logout</button>';
                } elseif ($_SESSION['user_role'] == 'seller') {
                    echo '<button id="login-button" onclick="location.href=\'../user/sellerDash.php\'">Dashboard</button>';
                    echo '<button id="signup-button" onclick="location.href=\'logout.php\'">Logout</button>';
                }
            } else {
                echo '<button id="login-button" onclick="openLoginModal()">Login</button>';
                echo '<button id="signup-button" onclick="openModal()">Sign Up</button>';
            }
            ?>
        </section>

    </main>

    <div id="login-modal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeLoginModal()">&times;</span>
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div>
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                <div>
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <div>
                    <button type="submit" id="login-button">Login</button>
                </div>
            </form>
        </div>
    </div>


    <div id="signup-modal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeModal()">&times;</span>
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <div>
                <label for="fName">First Name:</label>
                <input type="text" id="fName" name="fName" required oninput="validateForm()">
            </div>
            <div>
                <label for="lName">Last Name:</label>
                <input type="text" id="lName" name="lName" required oninput="validateForm()">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required oninput="checkEmail()">
                <span id="emailStatus"></span>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required oninput="validateForm()">
            </div>
            <div>
                <label for="role">Role:</label>
                <select id="role" name="role" required oninput="validateForm()">
                    <option value="seller">Seller</option>
                    <option value="buyer">Buyer</option>
                </select>
            </div>
            <div>
                <button type="submit" id="signup-button">Sign Up</button>
            </div>
        </form>
    </div>
</div>

<div class="homes-section">
    <div class="recent-label">
        <h2>Recently Added Homes</h2>
        <a href="#" class="view-all-button">View All</a>
    </div>

    <div class="homes-container">
        <?php
        $recentlyAddedHomes = getRecentHomes();

        if (!empty($recentlyAddedHomes)) {
            foreach ($recentlyAddedHomes as $home) {
                // Wrap each home card with an anchor link
                echo '<a href="../user/propertyDetails.php?propertyID=' . $home['PropertyID'] . '" class="home-link">';
                echo '<div class="home-card">';
                $imageURLs = getPropertyImages($home['PropertyID']);

                echo '<img class="home-image" src="' . (!empty($imageURLs) ? $imageURLs[0] : 'placeholder.jpg') . '" alt="Home Image">'; // Display the first image

                echo '<div class="home-info">';
                echo '<p class="home-location">' . $home['Location'] . '</p>'; // Display property location
                echo '<p class="home-value">$' . $home['PropertyValue'] . '</p>'; // Display property value
                echo '</div>'; // Close the home-info div
                echo '</div>'; // Close the home-card div
                echo '</a>'; // Close the anchor link
            }
        } else {
            echo '<p>No recently added homes found.</p>';
        }
        ?>
    </div>
</div>



<script src="index.js"></script>

<script>
const testimonials = document.querySelectorAll('.testimonial');
let currentTestimonial = 0;
let intervalId; // Variable to store the interval ID

function showTestimonial(index) {
    testimonials.forEach((testimonial, i) => {
        testimonial.style.display = i === index ? 'block' : 'none';
    });
}

function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    showTestimonial(currentTestimonial);
}

function prevTestimonial() {
    currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
    showTestimonial(currentTestimonial);
}

function startInterval() {
    intervalId = setInterval(nextTestimonial, 10000); // Change testimonial every 10 seconds
}

// Initialize by showing the first testimonial and start the interval
showTestimonial(currentTestimonial);
startInterval();

// Add event listeners to navigation buttons
const prevButton = document.getElementById('prevTestimonial');
const nextButton = document.getElementById('nextTestimonial');

prevButton.addEventListener('click', () => {
    clearInterval(intervalId); // Clear the existing interval
    prevTestimonial();
    startInterval(); // Start a new interval
});

nextButton.addEventListener('click', () => {
    clearInterval(intervalId); // Clear the existing interval
    nextTestimonial();
    startInterval(); // Start a new interval
});
</script>


</body>
</html>
