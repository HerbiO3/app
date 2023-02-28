<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function refresh_session(){
    if(!isset($_SESSION["user"])){
        session_destroy();
        return;
    }
    $config = include "../config.php";

    // Create connection
    $conn = mysqli_connect($config["servername"], $config["username"], $config["password"], $config["database"]);

    // Check connection
    if (!$conn) {
        session_destroy();
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM user WHERE id=?";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("i", $_SESSION["user"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = mysqli_fetch_object($result);

    if(is_null($value)) {
        //neuspešné prihlásenie
        session_destroy();
        header("Location: ../../app/index.php?badcred=true");
    }else{
        $_SESSION["user"]=$value->id;
        $_SESSION["super"]=$value->superuser;
    }
}
