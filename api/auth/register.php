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
if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['password2'])){
    $query = "INSERT INTO user (email, password, superuser) VALUES (?, ?, ?);";
    $stmt = $conn->prepare($query);
    $crypt_pass = password_hash($_GET['password'], PASSWORD_BCRYPT);
    $superuser = 0;
    $stmt->bind_param("ssi", $_GET['username'], $crypt_pass, $superuser);
    $stmt->execute();
    header("Location: ../../app/settings.php");
    die();
} else{
    header("Location: ../../app/settings.php");
    die();
}
?>