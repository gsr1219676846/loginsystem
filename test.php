<?php
//Database connection information
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "usbw";
$dbName     = "steven_db";

//Try to connect to the database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if($conn->connect_error){
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful.<br>";
}

//User email to check
$testEmail = 'test@example.com';

// Prepare SQL query
$query = "SELECT * FROM users WHERE email = '" . $conn->real_escape_string($testEmail) . "'";

//Execute query
$result = $conn->query($query);

// Check query results
if($result->num_rows > 0){
    echo "Find matching users:" . $testEmail;
} else {
    echo "No matching user found:" . $testEmail;
}

//Close database connection
$conn->close();
?>
