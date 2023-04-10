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

    // Check if all required parameters are set
    if (isset($_POST['unit']) && isset($_POST['name']) && isset($_POST['mode']) && isset($_POST['min_humidity']) && isset($_POST['water_time']) && isset($_POST['valve_id']) && isset($_POST['water_start']) && isset($_POST['water_next'])) {

        // Retrieve the POST data
        $unitId = $_POST['unit'];
        $name = $_POST['name'];
        $mode = $_POST['mode'];
        $minHumidity = $_POST['min_humidity'];
        $waterTime = $_POST['water_time'];
        $valveId = $_POST['valve_id'];
        $waterStart = $_POST['water_start'];
        $waterNext = $_POST['water_next'];


        // Check if unit with the provided ID exists
        $checkQuery = "SELECT `id` FROM `unit` WHERE `id` = ?";
        $checkStmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "i", $unitId);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            // Unit with the provided ID exists, proceed with insertion
            // Prepare the SQL query
            $query = "INSERT INTO `unit` (`id`, `name`, `mode`, `min_humidity`, `water_time`, `valve_id`, `water_start`, `water_next`) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $query);

            // Bind the parameters to the statement
            mysqli_stmt_bind_param($stmt, "issiiiss", $unitId, $name, $mode, $minHumidity, $waterTime, $valveId, $waterStart, $waterNext);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Check if the insertion was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Set HTTP status to 201 (Created)
                header('HTTP/1.1 201 Created');
                echo "Data inserted successfully!";
            } else {
                // Set HTTP status to 500 (Internal Server Error)
                header('HTTP/1.1 500 Internal Server Error');
                echo "Failed to insert data.";
            }
        } else {
            header("HTTP/1.1 404 Not Found");
            echo "Unit not exist.";
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo "Missing parameters.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Invalid request method.";
}