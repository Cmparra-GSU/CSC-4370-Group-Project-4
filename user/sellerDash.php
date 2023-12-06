<?php
include '../functions/generalFunctions.php';
include '../functions/accountFunctions.php';

// Get the seller's ID from the session (you should have this from the login)
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <!-- Include any additional CSS files here -->
</head>
<body>
    <header>
        <!-- Navigation bar, logo, etc. -->
    </header>

    <main>
        <h1>Welcome to Your Seller Dashboard</h1>
        <a href = "../index/index.php">back</a>
        <!-- Seller Information Overview -->
        <section id="seller-info">
            <h2>Your Information</h2>
            <?php
            // Include your accountFunctions.php
            
            $sellerID = $_SESSION['user_id']; // Replace 'seller_id' with your session variable name

            // Call the getSellerInformation function to fetch seller info
            $sellerInfo = getSellerInfo($sellerID);

            if ($sellerInfo) {
                echo "<p>Name: " . $sellerInfo['name'] . "</p>";
                echo "<p>Email: " . $sellerInfo['email'] . "</p>";
                // Include more seller info here
            } else {
                echo "<p>Seller information not found.</p>";
            }
            ?>
        </section>

        <!-- Properties List -->
        <section id="properties-list">
            <h2>Your Properties for Sale</h2>
            <?php
            // Assuming you have a database connection established
            // Fetch seller's properties from the database
            // $properties = fetchPropertiesFromDatabase();

            if (empty($properties)) {
                echo "<p>You haven't listed any properties, please add one now.</p>";
            } else {
                // Iterate through properties and display them
                foreach ($properties as $property) {
                    echo "<div class='property'>";
                    echo "<h3>" . $property['name'] . "</h3>";
                    // Include more property details here
                    echo "</div>";
                }
            }
            ?>

            <!-- Button to Add New Property -->
            <button onclick="window.location.href='addProperty.php'">+ Add New Property</button>
        </section>
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
    
    <!-- JavaScript files -->
</body>
</html>
