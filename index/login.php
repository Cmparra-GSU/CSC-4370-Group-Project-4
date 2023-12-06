<?php
session_start();
include '../functions/generalFunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connect();

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format (you can reuse the email validation code from your signup script)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = "Invalid email format";
        header('Location:index.php'); // Redirect to your login page
        exit();
    }

    // Retrieve the hashed password for the given email
    $query = "SELECT hashedPass, role, UID FROM User WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashedPassword, $role, $userID);
    $stmt->fetch();
    $stmt->close();

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Password is correct, set session variables and redirect
        $_SESSION['logged_in'] = true;
        $_SESSION['user_role'] = $role;
        $_SESSION['user_id'] = $userID;

        // Redirect based on role
        if ($role == 'buyer') {
            header('Location: ../user/buyerDash.php');
        } elseif ($role == 'seller') {
            header('Location: ../user/sellerDash.php');
        } else {
            // Handle other roles or redirect to a default page
        }
        exit();
    } else {
        // Incorrect password, display an error message
        $_SESSION['login_error'] = "Incorrect email or password";
        header('Location: index.php'); // Redirect to your login page
        exit();
    }
}
?>
