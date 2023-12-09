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
        <a href="../index/index.php" class="back-link">Back to Home</a>
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
                    echo '<div class="property">';
                    echo '<div class="property-info">';
                    echo '<p>' . $property['Location'] . '</p>';
                    echo '<p>' . $status . '</p>'; // Wrap the status in a <p> tag
                    echo '</div>';
                    
                    // Create a container div for the buttons
                    echo '<div class="button-container">';
                    echo '<a href="propertyDetails.php?propertyID=' . $property['PropertyID'] . '" class="buttons view-button">View</a>';
                    echo '<a href="editProperty.php?propertyID=' . $property['PropertyID'] . '" class="buttons edit-button">Edit</a>';
                    echo '<a href="#" class="buttons delete-button" onclick="showDeleteConfirmation(' . $property['PropertyID'] . ')">Delete</a>';
                    echo '</div>'; // Close the button container div
                
                    echo '</div>';
                }
            }
            ?>

            <!-- Button to Add New Property -->
            <button onclick="window.location.href='addProperty.php'" class="add-button">+ Add New Property</button>
        </section>
    </main>
    <div id="deleteConfirmationModal" class="modal">
    <div class="modal-content">
        <h2>Delete Property</h2>
        <p>Are you sure you want to delete this property?</p>
        <button class="common-button" onclick="deleteProperty(<?php echo $property['PropertyID']; ?>)">Yes</button>
        <button class="common-button" onclick="closeDeleteConfirmation()">No</button>
    </div>
</div>

    <footer>
        <!-- Footer content -->
    </footer>
    
    <!-- JavaScript files -->
</body>
</html>
