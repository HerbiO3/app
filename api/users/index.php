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
    $user = json_decode(file_get_contents('php://input'), true);
    if(!$user['userId']) return;

    $query = "INSERT into audit_log (user, type, info) VALUES  (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $logType = 'init';
    $logInfo = 'Executing user ' . '(id ' . $user['userId'] . ')' . ' permissions change';
    $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
    $stmt->execute();

    $query = "SELECT * FROM user WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user['userId']);
    $stmt->execute();
    $result = $stmt->get_result();
    $value = mysqli_fetch_object($result);
    if (is_null($value)) return;

    try {
        $conn->begin_transaction();

        $query = "UPDATE user SET verified=?, superuser=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $user['verified'], $user['superUser'], $user['userId']);
        $stmt->execute();

        $query = "INSERT into audit_log (user, type, info) VALUES  (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $verified = !$user['verified'] ? 0 : 1;
        $logInfo = 'Change user ' . '(id ' . $user['userId'] . ')' . ' verified to ' . $verified;
        $logType = 'update';
        $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
        $stmt->execute();

        $stmt = $conn->prepare($query);
        $super_user = !$user['superUser'] ? 0 : 1;
        $logInfo = 'Change user ' . '(id ' . $user['userId'] . ')' . ' superuser to ' . $super_user;
        $logType = 'update';
        $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
        $stmt->execute();

        $conn->commit();
    } catch (\Throwable $e) {
        $conn->rollback();
    }
}