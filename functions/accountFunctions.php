<?php

include_once 'generalFunctions.php';

function getSellerInfo($sellerID) {
    // Establish the database connection
    $conn = connect();

    // Define the SQL query to fetch seller information
    $sql = "SELECT fName, lName, email, /* add more fields here */ FROM User WHERE UID = ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind the seller ID as a parameter
    $stmt->bind_param("i", $sellerID);

    // Execute the query
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($fName, $lName, $email /* add more fields here */);

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

?>
