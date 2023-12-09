<?php
function connect() {
    $servername = "localhost";
    $username = "cparra3";
    $password = "cparra3";
    $dbname = "cparra3";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getPropertyById($propertyID, $userUID) {
    $conn = connect(); // Establish a database connection

    try {
        // Prepare a SQL query to retrieve the property data including the owner's ID
        $query = "SELECT * FROM Property WHERE PropertyID = ? AND PropertyID IN (SELECT PropertyID FROM forSale WHERE UserUID = ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $propertyID, $userUID);

        // Execute the query
        $stmt->execute();

        // Fetch the property data as an associative array
        $result = $stmt->get_result();
        $property = $result->fetch_assoc();

        return $property;
    } catch (Exception $e) {
        // Handle any database errors here
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}

function updateProperty($propertyID, $newLocation, $newAge, $newSquareFootage, $newBedrooms, $newBathrooms, $newGarden, $newParking, $newNearbyFacilities, $newNearbyMainRoads, $newPropertyValue, $newStatus, $userUID) {
    $conn = connect(); // Establish a database connection

    try {
        // Prepare a SQL query to update the property information
        $query = "UPDATE Property 
                  SET Location = ?, 
                      Age = ?, 
                      SquareFootage = ?, 
                      Bedrooms = ?, 
                      Bathrooms = ?, 
                      Garden = ?, 
                      Parking = ?, 
                      nearbyFacilities = ?, 
                      nearbyMainRoads = ?, 
                      PropertyValue = ?, 
                      status = ? 
                  WHERE PropertyID = ? AND PropertyID IN (SELECT PropertyID FROM forSale WHERE UserUID = ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('siiiiiiissiii', $newLocation, $newAge, $newSquareFootage, $newBedrooms, $newBathrooms, $newGarden, $newParking, $newNearbyFacilities, $newNearbyMainRoads, $newPropertyValue, $newStatus, $propertyID, $userUID);

        // Execute the query
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            return true; // Update successful
        } else {
            return false; // No rows were affected, possibly the property ID doesn't exist
        }
    } catch (Exception $e) {
        // Handle any database errors here
        echo "Error: " . $e->getMessage();
        return false; // Update failed
    } finally {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}

function getPropertyImages($propertyID) {
    $conn = connect(); // Replace with your database connection function

    $propertyID = mysqli_real_escape_string($conn, $propertyID);

    $query = "SELECT imageURL FROM PropertyImage WHERE PropertyID = $propertyID";

    $result = mysqli_query($conn, $query);

    $imageURLs = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imageURLs[] = $row['imageURL'];
        }
    }

    mysqli_close($conn);

    return $imageURLs;
}

function getUserInfo($userUID) {
    $conn = connect();

    try {
        // Prepare a SQL query to retrieve user information
        $query = "SELECT * FROM User WHERE UID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userUID);

        // Execute the query
        $stmt->execute();

        // Fetch user data as an associative array
        $result = $stmt->get_result();
        $userInfo = $result->fetch_assoc();

        return $userInfo;
    } catch (Exception $e) {
        // Handle any database errors here
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}

// generalFunctions.php

// ... (existing code)

function getAllProperties() {
    $conn = connect();

    try {
        $query = "SELECT * FROM Property";
        $result = $conn->query($query);

        if ($result) {
            $properties = $result->fetch_all(MYSQLI_ASSOC);
            return $properties;
        } else {
            // Handle query error
            echo "Error: " . $conn->error;
            return null;
        }
    } catch (Exception $e) {
        // Handle any other errors
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $conn->close();
    }
}
function addToWishlist($userUID, $propertyID) {
    $conn = connect();

    try {
        $query = "INSERT INTO Wishlist (UserUID, PropertyID) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $userUID, $propertyID);
        $stmt->execute();

        return true;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        $stmt->close();
        $conn->close();
    }
}

function getWishlist($userUID) {
    $conn = connect();

    try {
        $query = "SELECT * FROM Wishlist WHERE UserUID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $userUID);
        $stmt->execute();

        $result = $stmt->get_result();

        $wishlist = array();

        while ($row = $result->fetch_assoc()) {
            $wishlist[] = $row;
        }

        return $wishlist;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    } finally {
        $stmt->close();
        $conn->close();
    }
}



function updateUserInfo($userUID, $newName, $newEmail, $newPassword) {
    $conn = connect();

    try {
        // Prepare a SQL query to update user information
        $query = "UPDATE User 
                  SET fName = ?, 
                      email = ?, 
                      hashedPass = ? 
                  WHERE UID = ?";

        // Hash the new password before updating
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $newName, $newEmail, $hashedPassword, $userUID);

        // Execute the query
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            return true; // Update successful
        } else {
            return false; // No rows were affected, possibly the user ID doesn't exist
        }
    } catch (Exception $e) {
        // Handle any database errors here
        echo "Error: " . $e->getMessage();
        return false; // Update failed
    } finally {
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    }
}

?>
