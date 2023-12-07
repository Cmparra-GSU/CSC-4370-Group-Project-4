<?php
include('../functions/generalFunctions.php'); // Include to establish the database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $location = $_POST["location"];
    $age = $_POST["age"];
    $squareFootage = $_POST["squareFootage"];
    $bedrooms = $_POST["bedrooms"];
    $bathrooms = $_POST["bathrooms"];
    $garden = $_POST["garden"];
    $parking = $_POST["parking"];
    $nearbyFacilities = $_POST["nearbyFacilities"];
    $nearbyMainRoads = $_POST["nearbyMainRoads"];
    $propertyValue = $_POST["propertyValue"];
    $propertyImages = $_POST["propertyImages"];
    $propertyDescription = $_POST["propertyDescription"];

    // Establish the database connection using the connect function from generalFunctions.php
    $conn = connect();

    // Check if the connection was successful
    if ($conn) {
        // Insert data into the Property table
        $sql = "INSERT INTO Property (Location, Age, SquareFootage, Bedrooms, Bathrooms, Garden, Parking, nearbyFacilities, nearbyMainRoads, PropertyValue) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siiiiiiidd", $location, $age, $squareFootage, $bedrooms, $bathrooms, $garden, $parking, $nearbyFacilities, $nearbyMainRoads, $propertyValue);

        if ($stmt->execute()) {
            $propertyID = $stmt->insert_id;

            // Insert property images into PropertyImage table
            foreach ($propertyImages as $imageURL) {
                $imageSQL = "INSERT INTO PropertyImage (PropertyID, imageURL) VALUES (?, ?)";
                $imageStmt = $conn->prepare($imageSQL);
                $imageStmt->bind_param("is", $propertyID, $imageURL);
                $imageStmt->execute();
            }

            // Insert data into the ForSale table to associate the property with the seller
            $userUID = $_SESSION['user_id']; // Use the correct session variable name
            $forSaleSQL = "INSERT INTO ForSale (UserUID, PropertyID) VALUES (?, ?)";
            $forSaleStmt = $conn->prepare($forSaleSQL);
            $forSaleStmt->bind_param("ii", $userUID, $propertyID);
            $forSaleStmt->execute();

            // Close statements
            $stmt->close();
            $forSaleStmt->close();

            // Redirect to seller dashboard on success
            header("Location: sellerDash.php");
            exit();
        } else {
            // Handle error by displaying an error alert and redirecting back to addProperty.php
            echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href = "addProperty.php";</script>';
            exit();
        }
    } else {
        // Handle database connection error by displaying an error alert and redirecting back to addProperty.php
        echo '<script>alert("Database connection error."); window.location.href = "addProperty.php";</script>';
        exit();
    }
} else {
    // Handle invalid form submission by redirecting back to addProperty.php with an error alert
    echo '<script>alert("Invalid form submission."); window.location.href = "addProperty.php";</script>';
    exit();
}
?>
