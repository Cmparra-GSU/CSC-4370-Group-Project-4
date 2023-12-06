<?php
include('../functions/generalFunctions.php');
session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Property</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<header>
    <div class="container">
        <div class="navbar">
            <div class="logo">Add Property</div>
            <div class="button-group">
                <a href="admin.php" class="button">Admin Panel</a>
                <a href="../index/index.php" class="button">Index</a>
                <a href="../index/logout.php" class="button">Logout</a>
            </div>
        </div>
    </div>
</header>
<div class="main-content">
    <div class="create-content">
        <div class="createForm">
            <form id="propertyForm" method="POST" action="submit-property.php">

                <div class="formSection">
                    <label for="location">Location:</label><br>
                    <input type="text" id="location" name="location" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <label for="age">Age:</label><br>
                    <input type="number" id="age" name="age" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <label for="squareFootage">Square Footage:</label><br>
                    <input type="number" id="squareFootage" name="squareFootage" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <label for="bedrooms">Bedrooms:</label><br>
                    <input type="number" id="bedrooms" name="bedrooms" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <label for="bathrooms">Bathrooms:</label><br>
                    <input type="number" id="bathrooms" name="bathrooms" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <label>Garden:</label><br>
                    <input type="radio" id="garden_yes" name="garden" value="1">
                    <label for="garden_yes">Yes</label>
                    <input type="radio" id="garden_no" name="garden" value="0">
                    <label for="garden_no">No</label><br>
                </div>

                <div class="formSection">
                    <label>Parking:</label><br>
                    <input type="radio" id="parking_yes" name="parking" value="1">
                    <label for="parking_yes">Yes</label>
                    <input type="radio" id="parking_no" name="parking" value="0">
                    <label for="parking_no">No</label><br>
                </div>

                <div class="formSection">
                    <label for="nearbyFacilities">Nearby Facilities:</label><br>
                    <textarea id="nearbyFacilities" name="nearbyFacilities" rows="4" cols="50"></textarea><br>
                </div>

                <div class="formSection">
                    <label for="nearbyMainRoads">Nearby Main Roads:</label><br>
                    <textarea id="nearbyMainRoads" name="nearbyMainRoads" rows="4" cols="50"></textarea><br>
                </div>

                <div class="formSection">
                    <label for="propertyValue">Property Value:</label><br>
                    <input type="number" id="propertyValue" name="propertyValue" step="0.01" placeholder="Required" required><br>
                </div>

                <div class="formSection">
                    <div id =propertyImagesContainer>
                        <label for="propertyImages">Property Images:</label><br>
                        <button type="button" id="addPropertyImage" class="addrem">+</button>
                        <button type="button" id="removePropertyImage" class="addrem">-</button><br>
                        <input type="text" id="propertyImageURLs" name="propertyImages[]" placeholder="Enter image URL" required><br>
                    </div>
                </div>

                <div class="formSection">
                    <label for="propertyDescription">Property Description:</label><br>
                    <textarea id="propertyDescription" name="propertyDescription" rows="10" cols="80" placeholder="Required. Enter property description here..." required></textarea><br>
                </div>

                <input type="submit" value="Add Property">
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const propertyImagesContainer = document.getElementById('propertyImagesContainer');
    const addPropertyImageButton = document.getElementById('addPropertyImage');
    const removePropertyImageButton = document.getElementById('removePropertyImage');

    addPropertyImageButton.addEventListener('click', function() {
        const propertyImageInput = document.createElement('input');
        propertyImageInput.type = 'text';
        propertyImageInput.name = 'propertyImages[]';
        propertyImageInput.placeholder = 'Enter image URL';
        propertyImagesContainer.appendChild(propertyImageInput);
    });

    removePropertyImageButton.addEventListener('click', function() {
        if (imageCount > 1) {
            const lastPropertyImageInput = propertyImagesContainer.querySelector('input[name="propertyImages[]"]:last-child');
            lastPropertyImageInput.remove();
        }
    });
});

</script>
</body>
</html>
