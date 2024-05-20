<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "soildata");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get original and new ID from GET request
$originalId = $_GET["original_id"];
$newId = $_GET["new_id"];

// Update ID in soil_list table
$sql = "UPDATE soil_list SET id = '$newId' WHERE id = '$originalId'";
if ($conn->query($sql) === TRUE) {
    echo "ID updated successfully";
} else {
    echo "Error updating ID: " . $conn->error;
}

// Close connection
$conn->close();
?>
