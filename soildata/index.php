<?php
// Establish database connection
$conn = new mysqli("localhost", "root", "", "soildata");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form submitted and insert data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
    // Get form data
    $location = $_POST["location"];
    $nutrientName = $_POST["nutrient_name"];
    $nutrientValue = $_POST["nutrient_value"];

    // Insert data into soil_list table
    $sql = "INSERT INTO soil_list (location, nutrient_name, nutrient_value) VALUES ('$location', '$nutrientName', '$nutrientValue')";
    if ($conn->query($sql) === TRUE) {
        // Redirect to the same page to prevent resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soil Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Soil Management</h1>
        
        <h2>Create/Update Soil</h2>
        <form id="soilForm" method="post">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required><br>
            <label for="nutrient_name">Nutrient Name:</label>
            <input type="text" id="nutrient_name" name="nutrient_name" required><br>
            <label for="nutrient_value">Nutrient Value:</label>
            <input type="number" step="any" id="nutrient_value" name="nutrient_value" required><br>
            <button type="submit" name="create" id="createButton">Create</button>
        </form>

        <h2>Soil List</h2>
        <table id="soilTable" class="entity-table">
            <thead>
                <tr>
                    <th>Soil ID</th>
                    <th>Location</th>
                    <th>Nutrient Name</th>
                    <th>Nutrient Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                $conn = new mysqli("localhost", "root", "", "soildata");

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if form submitted and insert data into the database
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
                    // Get form data
                    $location = $_POST["location"];
                    $nutrientName = $_POST["nutrient_name"];
                    $nutrientValue = $_POST["nutrient_value"];

                    // Insert data into soil_list table
                    $sql = "INSERT INTO soil_list (location, nutrient_name, nutrient_value) VALUES ('$location', '$nutrientName', '$nutrientValue')";
                    if ($conn->query($sql) === TRUE) {
                        // Refresh the page to avoid resubmitting the form
                        header("Location: " . $_SERVER["PHP_SELF"]);
                        exit;
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                // Fetch data from soil_list table
                $query = $conn->query("SELECT * FROM soil_list");

                // Check if query was successful
                if ($query->num_rows > 0) {
                    $index = 1;
                    while ($row = $query->fetch_assoc()) {
                        echo "<tr data-row-id='{$row['id']}' data-original-id='{$row['id']}'>";
                        echo "<td>{$index}</td>";
                        echo "<td>{$row['location']}</td>";
                        echo "<td>{$row['nutrient_name']}</td>";
                        echo "<td>{$row['nutrient_value']}</td>";
                        echo "<td><button class='edit-btn'>Edit</button> <button class='delete-btn'>Delete</button></td>";
                        echo "</tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="script.js"></script>
</body>
</html>
