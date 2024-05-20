<?php
// Establish database connection
$conn = new mysqli("localhost", "root", "", "soildata");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all parameters are set
if (isset($_GET["id"], $_GET["location"], $_GET["nutrient_name"], $_GET["nutrient_value"])) {
    $id = $_GET["id"];
    $location = $_GET["location"];
    $nutrientName = $_GET["nutrient_name"];
    $nutrientValue = $_GET["nutrient_value"];
    
    // Prepare and execute SQL query to update the record
    $sql = "UPDATE soil_list SET location='$location', nutrient_name='$nutrientName', nutrient_value='$nutrientValue' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Required parameters are missing";
}

// Close connection
$conn->close();
?>
