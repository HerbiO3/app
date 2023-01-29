<?php
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


//GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $t=time();
    //Get by id
    if(isset($_GET["unitId"])){
        //get unit
        $query = "SELECT id, name FROM unit WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['unitId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $unit = mysqli_fetch_object($result);
        if(is_null($unit)){
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(["err" => "Požadovaná jednotka sa nenašla!"]);
            return;
        }
        $unit->time=$t;

        //get sections
        $query = "SELECT id, name FROM section WHERE unit=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['unitId']);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $unit->sections[] = $row;
        }

        echo json_encode($unit);


//        if(intval($_GET["unitId"]) == 5){
//            echo '{"time": '.$t.', "name":"Fakulta chodba", "id":5, "sections":[ { "id": 5, "name": "Kvetináč 1", "unitName": "Fakulta chodba" }, { "id": 2, "name": "Kvetináč 2", "unitName": "Fakulta chodba" }, { "id": 3, "name": "Kvetináč 3", "unitName": "Fakulta chodba" } ] }';
//            return;
//        }else{
//            header("HTTP/1.1 404 NOT FOUND");
//            echo json_encode(["err" => "Požadovaná jednotka sa nenašla!"]);
//            return;
//        }
    //get all
    } else{
        $output = Array();
        $output["time"]=$t;
        //echo '{"time": '.$t.', "units": [ { "id": 5, "name": "Fakulta chodba" }, { "id": 2, "name": "Matúš Jokay" } ] }';
        $query = "SELECT id, name FROM unit";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $output["units"][] = $row;
        }
        echo json_encode($output);
        return;
    }
}
