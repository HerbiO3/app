<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    if (isset($_POST['unit']) && isset($_POST['name']) && isset($_POST['sensor_id']) && isset($_POST['sensor_type'])) {

        // Retrieve the POST data
        $unitId = $_POST['unit'];
        $name = $_POST['name'];
        $type = $_POST['sensor_type'];
        $sensorId = $_POST['sensor_id'];

        if ($type == "humidity" && !isset($_POST['section_id'])) {
            header("HTTP/1.1 400 Bad Request");
            echo "Missing section ID parameter.";
            return;
        }

        $sectionId = $_POST['section_id'];

        if ($name == '' || $valveId = '') {
            header("HTTP/1.1 400 Bad Request");
            echo "Empty parameters.";
            return;
        }

        if($type == "humidity") {
            $checkSectionQuery = "SELECT `id` FROM `section` WHERE `id` = ?";
            $checkSectionStmt = mysqli_prepare($conn, $checkSectionQuery);
            mysqli_stmt_bind_param($checkSectionStmt, "i", $sectionId);
            mysqli_stmt_execute($checkSectionStmt);
            mysqli_stmt_store_result($checkSectionStmt);
            if (mysqli_stmt_num_rows($checkSectionStmt) == 0) {
                header("HTTP/1.1 400 Bad Request");
                echo "Invalid section ID.";
                return;
            }
        }

        // Check if unit with the provided ID exists
        $checkUnitQuery = "SELECT `id` FROM `unit` WHERE `id` = ?";
        $checkUnitStmt = mysqli_prepare($conn, $checkUnitQuery);
        mysqli_stmt_bind_param($checkUnitStmt, "i", $unitId);
        mysqli_stmt_execute($checkUnitStmt);
        mysqli_stmt_store_result($checkUnitStmt);

        if (mysqli_stmt_num_rows($checkUnitStmt) > 0) {
            // Unit with the provided ID exists, proceed with insertion
            // Prepare the SQL query
            if ($type == 'humidity') {
                $query = "INSERT INTO `sensor` (`unit`, `name`, `type`, `section`, `sensor_id`) 
                      VALUES (?, ?, ?, ?, ?)";
            } else {
                $query = "INSERT INTO `sensor` (`unit`, `name`, `type`, `sensor_id`) 
                      VALUES (?, ?, ?, ?)";
            }

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $query);

            // Bind the parameters to the statement
            if ($type == 'humidity') {
                mysqli_stmt_bind_param($stmt, "issii", $unitId, $name, $type, $sectionId, $sensorId);
            } else {
                mysqli_stmt_bind_param($stmt, "issi", $unitId, $name, $type, $sensorId);
            }

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
