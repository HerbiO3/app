<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
session_start();
if(!isset($_SESSION["user"]) || !$_SESSION["super"]){
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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $t=time();
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $perPage = isset($_GET["per_page"]) ? (int)$_GET["per_page"] : 10;
    $offset = ($page - 1) * $perPage;

    if(isset($_GET["email"]) && $_GET["email"]!="null"){
        $query = "SELECT SQL_CALC_FOUND_ROWS id, email, verified, superuser FROM user WHERE email = ? ORDER BY id LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $_GET["email"], $offset, $perPage);
    }else{
        $query = "SELECT SQL_CALC_FOUND_ROWS id, email, verified, superuser FROM user ORDER BY id LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $offset, $perPage);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->prepare("SELECT FOUND_ROWS() as sum;");
    $stmt->execute();
    $result = $stmt->get_result();

    $ret = new stdClass();
    $ret->users = $users;
    $ret->count = $result->fetch_object()->sum;
    echo json_encode($ret);
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //TODO
}