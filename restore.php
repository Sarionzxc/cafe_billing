<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cafe_billing_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the file is uploaded
if (isset($_FILES['file_to_restore'])) {
    $file = $_FILES['file_to_restore']['tmp_name'];
    $file_name = $_FILES['file_to_restore']['name'];

    // Check if file is an SQL file
    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
    if ($extension !== 'sql') {
        echo "Error: Please upload an SQL file.";
        exit();
    }

    // Read the SQL file
    $sql = file_get_contents($file);

    // Execute the SQL queries
    if ($conn->multi_query($sql)) {
        echo "<script>window.open('http://localhost/phpmyadmin/', '_blank');</script>";
        echo "Database has been restored successfully.";
    } else {
        echo "Error restoring database: " . $conn->error;
    }
} else {
    echo "Error: No file selected.";
}

// Close the database connection
$conn->close();
?>