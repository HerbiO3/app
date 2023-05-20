<?php
$config = include "../config.php";

// Create connection
$conn = mysqli_connect($config["servername"], $config["username"], $config["password"], $config["database"]);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    } else if (!$value->verified) {
        //prihlásenie neovereného používateľa
        header("Location: ../../app/index.php?unverified=true");
    } else{
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
