<?php
include('../functions/generalFunctions.php');
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to the login page if not authenticated
    exit;
}

$userUID = $_SESSION['user_id'];

// Process form submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated user data from the form
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    // Validate input as needed

    // Update user information in the database
    if (updateUserInfo($userUID, $newName, $newEmail, $newPassword)) {
        echo "User information updated successfully.";
        // You can also redirect the user to a profile page or dashboard after a successful update
    } else {
        echo "Failed to update user information.";
    }
}

// Retrieve the current user information for pre-filling the form
$userInfo = getUserInfo($userUID);
?>

<!-- Your HTML form goes here -->
<form method="post" action="editProfile.php">
    <label for="newName">Name:</label>
    <input type="text" id="newName" name="newName" value="<?php echo htmlspecialchars($userInfo['fName']); ?>" required>

    <label for="newEmail">Email:</label>
    <input type="email" id="newEmail" name="newEmail" value="<?php echo htmlspecialchars($userInfo['email']); ?>" required>

    <label for="newPassword">Password:</label>
    <input type="password" id="newPassword" name="newPassword" placeholder="Enter new password">

    <button type="submit">Update Profile</button>
</form>
