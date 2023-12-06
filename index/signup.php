<?php
include '../functions/generalFunctions.php';

session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to database
    $conn = connect();

    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back to signup page with an error message
        // For example, using a session variable to pass the error message
        $_SESSION['signup_error'] = "Invalid email format";
        header('Location: signup_page.php'); // Redirect to your signup page
        exit();
    }

    // Check if the email already exists in the database
    $query = "SELECT COUNT(*) FROM User WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($emailCount);
    $stmt->fetch();
    $stmt->close();

    if ($emailCount > 0) {
        // Email already exists, display an error message
        $_SESSION['signup_error'] = "Email is already in use. Please choose a different email.";
        header('Location: signup_page.php'); // Redirect to your signup page
        exit();
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO User (fName, lName, email, hashedPass, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Get the generated UID
        $userID = mysqli_insert_id($conn);

        $_SESSION['logged_in'] = true;
        $_SESSION['user_role'] = $role;
        $_SESSION['user_id'] = $userID; // Store the user's ID in the session

        $stmt->close();
        $conn->close();

        // Redirect based on role
        if ($role == 'buyer') {
            header('Location: ../user/buyerDash.php');
        } else {
            header('Location: ../user/sellerDash.php');
        }
        exit();
    } else {
        // Handle other errors, redirect back to signup with error message
        $_SESSION['signup_error'] = "Error in registration";

        $stmt->close();
        $conn->close();

        header('Location: index.php');
        exit();
    }
}
?>
