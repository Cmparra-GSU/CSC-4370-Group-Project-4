<?php
include '../functions/generalFunctions.php';
include '../functions/accountFunctions.php';

// Check if the user is authenticated
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to the login page if not authenticated
    exit;
}

// Check if a propertyID is provided in the URL
if (!isset($_GET['propertyID']) || empty($_GET['propertyID'])) {
    echo "Property ID not provided.";
    exit;
}

$propertyID = $_GET['propertyID'];

// Retrieve the logged-in user's ID from the session
$userUID = $_SESSION['user_id'];

// Retrieve property data from the database based on the propertyID and userUID
$property = getPropertyById($propertyID, $userUID);

// Check if the property exists and belongs to the logged-in user
if (!$property) {
    echo "Property not found or you don't have permission to edit it.";
    exit;
}

// Process form submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated property data from the form
    $updatedData = [
        'Location' => $_POST['location'],
        'Age' => $_POST['age'],
        'SquareFootage' => $_POST['squareFootage'],
        'Bedrooms' => $_POST['bedrooms'],
        'Bathrooms' => $_POST['bathrooms'],
        'Garden' => isset($_POST['garden']) ? 1 : 0,
        'Parking' => isset($_POST['parking']) ? 1 : 0,
        'nearbyFacilities' => $_POST['nearbyFacilities'],
        'nearbyMainRoads' => $_POST['nearbyMainRoads'],
        'PropertyValue' => $_POST['propertyValue'],
        'status' => $_POST['status']
        // Add more fields here for other property attributes
    ];

    if (updateProperty(
        $propertyID,
        $updatedData['Location'],
        $updatedData['Age'],
        $updatedData['SquareFootage'],
        $updatedData['Bedrooms'],
        $updatedData['Bathrooms'],
        $updatedData['Garden'],
        $updatedData['Parking'],
        $updatedData['nearbyFacilities'],
        $updatedData['nearbyMainRoads'],
        $updatedData['PropertyValue'],
        $updatedData['status'],
        $userUID // Pass the user's ID here
    )) {
        echo "Property updated successfully.";
    } else {
        echo "Failed to update the property.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="seller.css">
</head>
<body>
    <header>
        <!-- Navigation bar, logo, etc. -->
    </header>

    <main>
        <h1>Edit Property</h1>
        <a href="sellerDash.php">Back to Seller Dashboard</a>

        <!-- Edit Property Form -->
        <form method="POST" action="">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['Location']); ?>" required>

            <label for="age">Age:</label>
            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($property['Age']); ?>" required>

            <label for="squareFootage">Square Footage:</label>
            <input type="text" id="squareFootage" name="squareFootage" value="<?php echo htmlspecialchars($property['SquareFootage']); ?>" required>

            <label for="bedrooms">Bedrooms:</label>
            <input type="text" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['Bedrooms']); ?>" required>

            <label for="bathrooms">Bathrooms:</label>
            <input type="text" id="bathrooms" name="bathrooms" value="<?php echo htmlspecialchars($property['Bathrooms']); ?>" required>

            <label for="garden">Garden:</label>
            <input type="checkbox" id="garden" name="garden" <?php echo $property['Garden'] ? 'checked' : ''; ?>>

            <label for="parking">Parking:</label>
            <input type="checkbox" id="parking" name="parking" <?php echo $property['Parking'] ? 'checked' : ''; ?>>

            <label for="nearbyFacilities">Nearby Facilities:</label>
            <textarea id="nearbyFacilities" name="nearbyFacilities"><?php echo htmlspecialchars($property['nearbyFacilities']); ?></textarea>

            <label for="nearbyMainRoads">Nearby Main Roads:</label>
            <textarea id="nearbyMainRoads" name="nearbyMainRoads"><?php echo htmlspecialchars($property['nearbyMainRoads']); ?></textarea>

            <label for="propertyValue">Property Value:</label>
            <input type="text" id="propertyValue" name="propertyValue" value="<?php echo htmlspecialchars($property['PropertyValue']); ?>" required>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="forSale" <?php echo $property['status'] === 'forSale' ? 'selected' : ''; ?>>For Sale</option>
                <option value="pending" <?php echo $property['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="sold" <?php echo $property['status'] === 'sold' ? 'selected' : ''; ?>>Sold</option>
            </select>

            <!-- Add more fields here for other property attributes -->

            <input type="submit" value="Save Changes">
        </form>
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
