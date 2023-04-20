<?php
session_start();
if(!isset($_SESSION["user"])){
    header("HTTP/1.1 401 Unauthorized");
    die("unauthorized");
}

$config = include "../config.php";
// Create connection
$conn = mysqli_connect($config["servername"], $config["username"], $config["password"], $config["database"]);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check if all parameters are set
    if (isset($_POST['name']) && isset($_POST['log_interval']) && isset($_POST['min_level']) && isset($_POST['max_level'])) {

        // Retrieve the POST data
        $name = $_POST['name'];
        $logInterval = $_POST['log_interval'];
        $minLevel = $_POST['min_level'];
        $maxLevel = $_POST['max_level'];
        $currentLevel = $_POST['min_level'];

        // Prepare the SQL query
        $query = "INSERT INTO `unit` (`name`, `log_interval`, `min_level`, `max_level`, `current_level`) 
                  VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind the parameters to the statement
        mysqli_stmt_bind_param($stmt, "siiii", $name, $logInterval, $minLevel, $maxLevel, $currentLevel);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check if the insertion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            header("HTTP/1.1 201 Created");
            echo "Data inserted successfully!";
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo "Failed to insert data.";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo "Missing parameters.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Invalid request method.";
}
?>
