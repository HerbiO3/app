<?php
$config = include "../config.php";

// Create connection
$conn = mysqli_connect($config["servername"], $config["username"], $config["password"], $config["database"]);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//https://herbio3.ddns.net/api/auth/?username=test%40stuba.sk&password=herbio3qetuo
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])) {
    $query = "INSERT INTO user (email, password, superuser) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $crypt_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $superuser = 0;
    $stmt->bind_param("ssi", $_POST['username'], $crypt_pass, $superuser);
    $stmt->execute();
}
header("Location: ../../app/index.php");
die();
