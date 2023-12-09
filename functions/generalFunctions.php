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
        $conn->close(); // Close the database connection
    }
}



function getRecentHomes() {
    $conn = connect(); // Replace with your database connection function

    // Define the query to fetch recently added homes
    $query = "SELECT Property.PropertyID, Property.Location, Property.PropertyValue
              FROM Property
              WHERE Property.status = 'forSale'  -- You can add additional conditions if needed
              ORDER BY Property.PropertyID DESC  -- Order by PropertyID (you can change the ordering criteria)
              LIMIT 5"; // Limit the results to the latest 5 properties, you can adjust this number as needed

    $result = mysqli_query($conn, $query);

    $recentlyAddedHomes = array();

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $recentlyAddedHomes[] = $row;
        }
    }

    mysqli_close($conn);

    return $recentlyAddedHomes;
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

function getPropertyDetails($propertyID) {
    $conn = connect(); // Replace with your database connection function

    // Sanitize the input
    $propertyID = mysqli_real_escape_string($conn, $propertyID);

    // Prepare a SQL query to retrieve the property details
    $query = "SELECT * FROM Property WHERE PropertyID = $propertyID";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch the property data as an associative array
        $property = mysqli_fetch_assoc($result);

        mysqli_close($conn);

        return $property;
    } else {
        // Handle the query error here
        echo "Error: " . mysqli_error($conn);
        mysqli_close($conn);
        return null;
    }
}

function getStatus($status) {
    switch ($status) {
        case 'forSale':
            return 'For Sale';
        case 'pending':
            return 'Pending';
        case 'sold':
            return 'Sold';
        default:
            return 'Unknown'; // Handle any unexpected status values
    }
}


?>
