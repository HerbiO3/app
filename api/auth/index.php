<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "herbioRemoteTeam";
$password = "banan";

// Create connection
$conn = mysqli_connect($servername, $username, $password, "herbio");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
//https://herbio3.ddns.net/api/auth/?username=test%40stuba.sk&password=herbio3qetuo
if(isset($_GET['username']) && isset($_GET['password'])){
    $query = "SELECT * FROM user WHERE email=? and password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $_GET['username'], $_GET['password']);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = mysqli_fetch_object($result);
    var_dump($value);
}
?>
