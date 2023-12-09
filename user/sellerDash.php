<?php
include '../functions/generalFunctions.php';
include '../functions/accountFunctions.php';

session_start();

// Get the seller's ID from the session
$userUID = $_SESSION['user_id'];

// Process form submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated user data from the form
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];
    if (isset($_POST['addToWishlist'])) {
        $propertyID = $_POST['propertyID'];
        addToWishlist($userUID, $propertyID);
    }

    // Validate input as needed

    // Update user information in the database
    if (updateUserInfo($userUID, $newName, $newEmail, $newPassword)) {
        echo "User information updated successfully.";
        // You can also redirect the user to a profile page or dashboard after a successful update
    } else {
        echo "Failed to update user information.";
    }
}

// Retrieve the current user information for pre-filling the form
$userInfo = getUserInfo($userUID);
// Retrieve properties for the logged-in user
$propertiesForSale = getProps($userUID);
$allProperties = getAllProperties();
$wishlist = getWishlist($userUID);

?>

<!DOCTYPE html>
<html lang="en">
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
        <a href="../index/index.php">back</a>

        <!-- Seller Information Overview -->
        <section id="seller-info">
            <h2>Your Information</h2>
            <?php
            // Display user information form for editing
            // ... (your existing code)
            ?>
        </section>

        <!-- Properties List -->
        <section id="properties-list">
            <h2>Properties You Listed for Sale</h2>
            <?php
            if (empty($propertiesForSale)) {
                echo "<p>You haven't listed any properties for sale, please add one now.</p>";
            } else {
                foreach ($propertiesForSale as $property) {
                    // Display properties listed by the current user
                    echo "<div class='property'>";
                    echo "<div class='property-info'>";
                    echo "<p><strong>Address:</strong> " . $property['Location'] . "</p>";
                    echo "<p><strong>Value:</strong> $" . $property['PropertyValue'] . "</p>";
                    echo "</div>";

                    // ... (your existing code)

                    // Add to Wishlist Form
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='propertyID' value='" . $property['PropertyID'] . "'>";
                    echo "<button type='submit' name='addToWishlist'>Add to Wishlist</button>";
                    echo "</form>";

                    echo "<a href='propertyDetails.php?propertyID=" . $property['PropertyID'] . "' class='view-button'>View</a>";
                    echo "</div>";
                }
            }
            ?>

            <h2>All Properties</h2>
            <?php
            if (empty($allProperties)) {
                echo "<p>No properties available at the moment.</p>";
            } else {
                foreach ($allProperties as $property) {
                    // Display all properties
                    echo "<div class='property'>";
                    echo "<div class='property-info'>";
                    echo "<p><strong>Address:</strong> " . $property['Location'] . "</p>";
                    echo "<p><strong>Value:</strong> $" . $property['PropertyValue'] . "</p>";
                    echo "</div>";

                    // ... (your existing code)

                    // Add to Wishlist Form
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='propertyID' value='" . $property['PropertyID'] . "'>";
                    echo "<button type='submit' name='addToWishlist'>Add to Wishlist</button>";
                    echo "</form>";

                    echo "<a href='propertyDetails.php?propertyID=" . $property['PropertyID'] . "' class='view-button'>View</a>";
                    echo "</div>";
                }
            }
            ?>
        </section>

        <h2>Wishlist</h2>
        <?php
        if (empty($wishlist)) {
            echo "<p>Your wishlist is empty.</p>";
        } else {
            foreach ($wishlist as $wishlistItem) {
                // Display properties in the wishlist
                $property = getPropertyById($wishlistItem['PropertyID'], $userUID);
                if ($property) {
                    echo "<div class='property'>";
                    echo "<div class='property-info'>";
                    echo "<p><strong>Address:</strong> " . $property['Location'] . "</p>";
                    echo "<p><strong>Value:</strong> $" . $property['PropertyValue'] . "</p>";
                    // ... (your existing code)
                    echo "</div>";
                    echo "<a href='propertyDetails.php?propertyID=" . $property['PropertyID'] . "' class='view-button'>View</a>";
                    echo "</div>";
                }
            }
        }
        ?>
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
    
    <!-- JavaScript files -->
</body>
</html>

