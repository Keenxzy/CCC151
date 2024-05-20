<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "soildata");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID from GET request
$id = $_GET["id"];

// Delete row from soil_list table
$sql = "DELETE FROM soil_list WHERE id = '$id'";
if ($conn->query($sql) === TRUE) {
    // Reset auto-increment value
    $conn->query("ALTER TABLE soil_list AUTO_INCREMENT = 1");
    
    // Update IDs to be sequential
    $query = $conn->query("SELECT * FROM soil_list ORDER BY id");
    $index = 1;
    while ($row = $query->fetch_assoc()) {
        $originalId = $row['id'];
        $conn->query("UPDATE soil_list SET id = '$index' WHERE id = '$originalId'");
        $index++;
    }
    echo "Row deleted and IDs reset successfully";
} else {
    echo "Error deleting row: " . $conn->error;
}

// Close connection
$conn->close();
?>
