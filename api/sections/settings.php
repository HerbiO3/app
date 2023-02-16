<?php
//GET - get section data to prefill form

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $t=time();
    $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
    $perPage = isset($_GET["per_page"]) ? (int)$_GET["per_page"] : 10;
    $offset = ($page - 1) * $perPage;

    $query = "SELECT unit.log_interval as logInterval, section.name, section.mode, section.min_humidity as minHumidity, section.water_time as waterTime, section.water_start as waterStart, section.water_next as waterNext FROM section join unit on section.unit = unit.id WHERE section.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $section = $result->fetch_object();
    if(is_null($section)){
        header("HTTP/1.1 404 NOT FOUND");
        echo json_encode(["err" => "Požadovaná sekcia sa nenašla!"]);
        return;
    }

    $section->admin = $_SESSION["super"];
    echo json_encode($section);
    return;
}


//POST - update settings in section
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION["user"]) || !$_SESSION["super"]) {
        header("HTTP/1.1 401 Unauthorized");
        die("unauthorized");
    }
    if (!isset($_POST["water-time-seconds"]) || !isset($_POST["mode"]) || !isset($_POST["section-id"]) || !isset($_POST["min-humidity-percent"]) || !isset($_POST["datetime-start"]) || !isset($_POST["datetime-next"]) || !isset($_POST["log-interval-minutes"])) {
        header("HTTP/1.1 422 Unprocessable Entity");
        echo "požadované parametre chýbajú, alebo sú poškodené";
        return;
    }

    $query = "INSERT into audit_log (user, type, info) VALUES  (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $logType = 'init';
    $logInfo = 'Executing section ' . '(id ' . $_POST["section-id"] . ')' . ' setting change';
    $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
    $stmt->execute();

    $query = "SELECT unit.id FROM section join unit on section.unit = unit.id WHERE section.id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_POST["section-id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result == false) {
        header("HTTP/1.1 404 NOT FOUND");
        echo "jednotka vybranej sekcie sa nenašla";
        return;
    }
    $unit = mysqli_fetch_object($result);

    try {
        $conn->begin_transaction();

        $waterTimeMs = round($_POST["water-time-seconds"] * 1000);
        $logTimeMs = round($_POST["log-interval-minutes"] * 60000);

        if ($_POST["mode"] == 'manual') {
            $query = "UPDATE section INNER JOIN unit on section.unit = unit.id SET unit.log_interval=?, section.mode=?, section.water_time=? WHERE section.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('isii', $logTimeMs, $_POST["mode"], $waterTimeMs, $_POST["section-id"]);
        } elseif ($_POST["mode"] == 'auto') {
            $query = "UPDATE section INNER JOIN unit on section.unit = unit.id SET unit.log_interval=?, section.mode=?, section.water_time=?, section.min_humidity=? WHERE section.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('isiii', $logTimeMs, $_POST["mode"], $waterTimeMs, $_POST["min-humidity-percent"], $_POST["section-id"]);
        } elseif ($_POST["mode"] == 'timed') {
            $timeStart = date("Y-m-d H:i:s", strtotime($_POST["datetime-start"]));
            $timeNext = date("Y-m-d H:i:s", strtotime($_POST["datetime-next"]));
            $query = "UPDATE section INNER JOIN unit on section.unit = unit.id SET unit.log_interval=?, section.mode=?, section.water_time=?, section.water_start=?, section.water_next=? WHERE section.id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('isissi', $logTimeMs, $_POST["mode"], $waterTimeMs, $timeStart, $timeNext, $_POST["section-id"]);
        } else {
            header("HTTP/1.1 406 Not Acceptable");
            echo "požadovaný zavlažovací mód neexistuje";
            return;
        }
        $stmt->execute();

        $query = "INSERT into audit_log (user, type, info) VALUES  (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $logType = 'update';
        $logInfo = 'Change unit ' . '(id ' . $unit->id . ')' . ' log_interval to ' . $logTimeMs;
        $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
        $stmt->execute();

        $stmt = $conn->prepare($query);
        $logInfo = 'Change section ' . '(id ' . $_POST["section-id"] . ')' . ' mode to ' . $_POST["mode"];
        $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
        $stmt->execute();

        $stmt = $conn->prepare($query);
        $logInfo = 'Change section ' . '(id ' . $_POST["section-id"] . ')' . ' water_time to ' . $waterTimeMs;
        $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
        $stmt->execute();

        if ($_POST["mode"] == 'auto') {
            $stmt = $conn->prepare($query);
            $logInfo = 'Change section ' . '(id ' . $_POST["section-id"] . ')' . ' min_humidity to ' . $_POST["min-humidity-percent"];
            $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
            $stmt->execute();
        } elseif ($_POST["mode"] == 'timed') {
            $stmt = $conn->prepare($query);
            $logInfo = 'Change section ' . '(id ' . $_POST["section-id"] . ')' . ' water_start to ' . $timeStart;
            $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
            $stmt->execute();
            $stmt = $conn->prepare($query);
            $logInfo = 'Change section ' . '(id ' . $_POST["section-id"] . ')' . ' water_next to ' . $timeNext;
            $stmt->bind_param('iss', $_SESSION['user'], $logType, $logInfo);
            $stmt->execute();
        }

        $conn->commit();
    } catch (\Throwable $e) {
        $conn->rollback();
        header("HTTP/1.1 400 Bad Request");
        echo $e->getMessage();
        return;
    }

    header("HTTP/1.1 200 OK");
    echo "nastavenie úspešne vykonané";
    $stmt->close();
}

