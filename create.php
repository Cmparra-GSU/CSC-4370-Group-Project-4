<?php
$host = "localhost";
$user = "cparra3";
$pass = "cparra3";
$dbname = "cparra3";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo "Could not connect to server\n";
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection Established\n";
}

// SQL statements to create tables
$sql = "
    CREATE TABLE User (
        UID INT AUTO_INCREMENT PRIMARY KEY,
        fName VARCHAR(255) NOT NULL,
        lName VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        hashedPass VARCHAR(255) NOT NULL,
        role ENUM('seller', 'buyer') NOT NULL
    );

    CREATE TABLE Property (
        PropertyID INT AUTO_INCREMENT PRIMARY KEY,
        Location VARCHAR(255) NOT NULL,
        Age INT NOT NULL,
        SquareFootage INT NOT NULL,
        Bedrooms INT NOT NULL,
        Bathrooms INT NOT NULL,
        Garden BOOLEAN NOT NULL,
        Parking BOOLEAN NOT NULL,
        nearbyFacilities TEXT,
        nearbyMainRoads TEXT,
        PropertyValue DECIMAL(10,2) NOT NULL,
        status ENUM('forSale', 'pending', 'sold') NOT NULL DEFAULT 'forSale'
    );

    CREATE TABLE CreditCard (
        CardID INT AUTO_INCREMENT PRIMARY KEY,
        UserID INT,
        cardNumber VARCHAR(255) UNIQUE NOT NULL,
        cardType ENUM('Visa', 'MasterCard', 'Amex', 'Discover') NOT NULL,
        expiryDate DATE NOT NULL,
        cardholderName VARCHAR(255) NOT NULL,
        FOREIGN KEY (UserID) REFERENCES User(UID)
    );

    CREATE TABLE PropertyImage (
        ImageID INT AUTO_INCREMENT PRIMARY KEY,
        PropertyID INT NOT NULL,
        imageURL VARCHAR(255) NOT NULL,
        FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
    );

    CREATE TABLE Wishlist (
        UserUID INT NOT NULL,
        PropertyID INT NOT NULL,
        PRIMARY KEY (UserUID, PropertyID),
        FOREIGN KEY (UserUID) REFERENCES User(UID),
        FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
    );

    CREATE TABLE ForSale (
        UserUID INT NOT NULL,
        PropertyID INT NOT NULL,
        PRIMARY KEY (UserUID, PropertyID),
        FOREIGN KEY (UserUID) REFERENCES User(UID),
        FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
    );
";

// Execute the SQL statements
if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully\n";
} else {
    echo "Error creating tables: " . $conn->error . "\n";
}

$conn->close();
?>
