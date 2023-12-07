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
    <link rel="stylesheet" href="seller.css">

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
            } else {
                echo "<p>Seller information not found.</p>";
            }
            ?>
        </section>

        <!-- Properties List -->
        <section id="properties-list">
            <h2>Your Properties for Sale</h2>
            <?php
            $userUID = $_SESSION['user_id'];

            $properties = getProps($userUID);

            if (empty($properties)) {
                echo "<p>You haven't listed any properties, please add one now.</p>";
            } else {
                foreach ($properties as $property) {
                    // TODO: add new functions for seeing who's wishlisted your property as well as property status (sold, pending, for sale)
                    echo "<div class='property'>";
                    echo "<div class='property-info'>";
                    echo "<p><strong>Address:</strong> " . $property['Location'] . "</p>"; // Adjust the field name as needed
                    echo "<p><strong>Value:</strong> $" . $property['PropertyValue'] . "</p>"; // Adjust the field name as needed
                    echo "</div>";
                
                    /* can't test because i don't have access to the codd server
                    $propertyImages = getPropertyImages($property['PropertyID']); // You need to implement this function
                    if (!empty($propertyImages)) {
                        $firstImageURL = $propertyImages[0]['imageURL'];
                        echo "<img src='$firstImageURL' class='property-image' alt='Property Image'>";
                    }*/
                
                    echo "<a href='propertyDetails.php?propertyID=" . $property['PropertyID'] . "' class='view-button'>View</a>";
                    echo "<a href='editProperty.php?propertyID=" . $property['PropertyID'] . "' class='edit-button'>Edit</a>";
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
