<?php
include_once '../functions/generalFunctions.php';
$conn = connect();

if(isset($_GET['email']) && !empty($_GET['email'])) {
    $email = strtolower(trim($_GET['email']));

    // Prepare a statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        echo "Email is already in use";
    } else {
        echo "Email available";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "No email provided";
}
?>
