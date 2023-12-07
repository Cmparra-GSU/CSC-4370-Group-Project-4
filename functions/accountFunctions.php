<?php

include_once 'generalFunctions.php';

function getSellerInfo($sellerID) {
    // Establish the database connection
    $conn = connect();

    // Define the SQL query to fetch seller information
    $sql = "SELECT fName, lName, email FROM User WHERE UID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the seller ID as a parameter
    $stmt->bind_param("i", $sellerID);

    // Execute the query
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($fName, $lName, $email);

    // Fetch the result (assuming there's only one row per seller ID)
    if ($stmt->fetch()) {
        $sellerInfo = array(
            'name' => $fName . ' ' . $lName,
            'email' => $email,
            // Add more fields as needed
        );
        // Close the statement
        $stmt->close();

        $conn->close();
        return $sellerInfo;
    } else {
        $conn->close();
        return null;
    }
}

function getProps($userUID) {
    // Establish a database connection (you may need to include generalFunctions.php for the connect function)
    $conn = connect();

    if ($conn) {
        // Prepare a SQL query to retrieve properties associated with the user
        $query = "SELECT Property.* FROM Property
                  INNER JOIN ForSale ON Property.PropertyID = ForSale.PropertyID
                  WHERE ForSale.UserUID = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userUID);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $properties = [];

            while ($row = $result->fetch_assoc()) {
                $properties[] = $row;
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();

            return $properties;
        } else {
            // Handle the query execution error if needed
            return false;
        }
    } else {
        // Handle the database connection error if needed
        return false;
    }
}

?>
