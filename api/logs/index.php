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
    $types = array();
    if(isset($_GET["init"]) && ($_GET["init"])!="false") $types[] ="audit_log.type = 'init'";
    if(isset($_GET["delete"]) && ($_GET["delete"])!="false") $types[] ="audit_log.type = 'delete'";
    if(isset($_GET["update"]) && ($_GET["update"])!="false") $types[] ="audit_log.type = 'update'";
    if(isset($_GET["create"]) && ($_GET["create"])!="false") $types[] ="audit_log.type = 'create'";

    $query_types="audit_log.type = 'none'";
    if ($types) {
        $query_types .= " OR ";
        $query_types .= implode(" OR ", $types);
    }
    if(isset($_GET["email"]) && $_GET["email"]!="null"){
        $query = "SELECT SQL_CALC_FOUND_ROWS audit_log.time, user.email as email, audit_log.type, audit_log.info FROM audit_log join user on audit_log.user = user.id WHERE email = ? AND (".$query_types.") ORDER BY audit_log.time DESC LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $_GET["email"], $offset, $perPage);
    }else{
        $query = "SELECT SQL_CALC_FOUND_ROWS audit_log.time, user.email as email, audit_log.type, audit_log.info FROM audit_log join user on audit_log.user = user.id WHERE ".$query_types." ORDER BY audit_log.time DESC LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $offset, $perPage);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $logs = $result->fetch_all(MYSQLI_ASSOC);

    $stmt = $conn->prepare("SELECT FOUND_ROWS() as sum;");
    $stmt->execute();
    $result = $stmt->get_result();

    $ret = new stdClass();
    $ret->logs = $logs;
    $ret->count = $result->fetch_object()->sum;
    echo json_encode($ret);
    return;
}


