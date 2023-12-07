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
                <span>Doors</span>
            </div>
        </div>
    </header>

    <main>
        <section id="about-us">
            
            <p>
                Welcome to Georgia Doors – Your Trusted Partner in Georgia Real Estate! We're your gateway to the vibrant and diverse property market of the Peach State.
            </p>
        </section>




        <section id="user-action">
            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
                // Check user role and redirect accordingly
                if ($_SESSION['user_role'] == 'buyer') {
                    echo '<button onclick="location.href=\'../user/buyerDash.php\'">Continue to Buyer Dashboard</button>';
                    echo '<a href="logout.php">Logout</a>';
                } elseif ($_SESSION['user_role'] == 'seller') {
                    echo '<button onclick="location.href=\'../user/sellerDash.php\'">Continue to Seller Dashboard</button>';
                    echo '<a href="logout.php">Logout</a>
                    ';
                }
            } else {
                echo '<button onclick="openLoginModal()">Login</button>';
                echo '<button onclick="openModal()">Sign Up</button>';
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


    <footer>
        <!-- Footer content here -->
    </footer>

<script src="index.js"></script>


</body>
</html>
