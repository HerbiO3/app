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
    $query = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("s", $_GET['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = mysqli_fetch_object($result);
    //var_dump($value);

    if(is_null($value) || !password_verify($_GET['password'], $value->password)){
        //neuspešné prihlásenie
        header("Location: ../../app/index.php?badcred=true");
    }else{
        //uspešné prihlásenie
        session_start();
        $_SESSION["user"]=$value->id;
        $_SESSION["super"]=$value->superuser;
        header("Location: ../../app/dashboard.php");
    }
} else{
    header("Location: ../../app/index.php");
}
die();
?>
