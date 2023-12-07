<?php
include '../functions/generalFunctions.php';

// Check if a propertyID is provided in the URL
if (!isset($_GET['propertyID']) || empty($_GET['propertyID'])) {
    echo "Property ID not provided.";
    exit;
}

$propertyID = $_GET['propertyID'];

// Retrieve property data from the database based on the propertyID
$property = getPropertyDetails($propertyID);

if (!$property) {
    echo "Property not found.";
    exit;
}

// Retrieve property images for the property
$propertyImages = getPropertyImages($propertyID);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Details</title>
    <link rel="stylesheet" href="propertyDetails.css">
</head>
<body>
    <header>
        <!-- Navigation bar, logo, etc. -->
    </header>

    <main>
        <h1>Property Details</h1>

        <section id="property-info">
            <h2>Property Information</h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($property['Location']); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($property['Age']); ?></p>
            <p><strong>Square Footage:</strong> <?php echo htmlspecialchars($property['SquareFootage']); ?> sq ft</p>
            <p><strong>Bedrooms:</strong> <?php echo htmlspecialchars($property['Bedrooms']); ?></p>
            <p><strong>Bathrooms:</strong> <?php echo htmlspecialchars($property['Bathrooms']); ?></p>
            <p><strong>Garden:</strong> <?php echo $property['Garden'] ? 'Yes' : 'No'; ?></p>
            <p><strong>Parking:</strong> <?php echo $property['Parking'] ? 'Yes' : 'No'; ?></p>
            <p><strong>Nearby Facilities:</strong> <?php echo htmlspecialchars($property['nearbyFacilities']); ?></p>
            <p><strong>Nearby Main Roads:</strong> <?php echo htmlspecialchars($property['nearbyMainRoads']); ?></p>
            <p><strong>Property Value:</strong> $<?php echo number_format($property['PropertyValue'], 2); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($property['status']); ?></p>
        </section>

        <section id="property-images">
            <h2>Property Images</h2>
            <?php
            if (!empty($propertyImages)) {
                foreach ($propertyImages as $imageURL) {
                    echo "<img src='" . htmlspecialchars($imageURL) . "' alt='Property Image'>";
                }
            } else {
                echo "<p>No images available for this property.</p>";
            }
            ?>
        </section>
        <button onclick="goBack()">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>

    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
