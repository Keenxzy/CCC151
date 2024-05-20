<?php
$conn = new mysqli("localhost", "root", "", "soildata");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$location = $_POST["location"];
$nutrientName = $_POST["nutrient_name"];
$nutrientValue = $_POST["nutrient_value"];

$sql = "INSERT INTO soil_list (location, nutrient_name, nutrient_value) VALUES ('$location', '$nutrientName', '$nutrientValue')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
