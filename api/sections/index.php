<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    //Get section histroy
    if(isset($_GET["sectionId"]) && $_GET["history"]){
        if($_GET["dateFrom"] && $_GET["dateTo"]){
            //echo '{"time": '.$t.', "id": 5, "name": "Kvetináč 1", "unitName": "Fakulta chodba", "waterLevel": 0.5, "uvIndex": 1, "airTemperature": 21, "humidity": [ { "sensorId": 3, "value":0.61 }, { "sensorId": 4, "value":0.63 } ], "tempHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":18 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":19 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":21 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":20 } ], "humidityHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.61 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.65 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.7 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.67 } ], "uvHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.6 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.7 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.5 } ], "levelHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.6 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.4 } ], "wateringHistory":[ { "timestamp":"2022-10-19T09:15:00.511Z", "value":1 }, { "timestamp":"2022-10-19T09:20:00.511Z", "value":0 }, { "timestamp":"2022-10-20T09:15:00.511Z", "value":1 }, { "timestamp":"2022-10-20T09:20:00.511Z", "value":0 } ] }';
            //get section
            $query = "SELECT section.id, unit.id as unitId FROM section join unit on section.unit = unit.id WHERE section.id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_GET['sectionId']);
            $stmt->execute();
            $result = $stmt->get_result();
            $section = mysqli_fetch_object($result);
            if(is_null($section)){
                header("HTTP/1.1 404 NOT FOUND");
                echo json_encode(["err" => "Požadovaná sekcia sa nenašla!"]);
                return;
            }

            $section->sensors = [];
            //get sensors with this unit without any section
            $query = "SELECT id, name, type FROM sensor WHERE sensor.unit=? and sensor.section is null";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $section->unitId);
            $stmt->execute();
            $sensors = $stmt->get_result();
            while($row = $sensors->fetch_assoc()) {
                $section->sensors[] = $row;
            }

            //get sensors with this section
            $query = "SELECT id, name, type FROM sensor WHERE sensor.section = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $section->id);
            $stmt->execute();
            $sensors = $stmt->get_result();
            while($row = $sensors->fetch_assoc()) {
                $section->sensors[] = $row;
            }

            //for all sensors:
            //get sensor logs
            $sensors_data = [];
            foreach ($section->sensors as $sensor){
                $data = [];
                //get sensors with this section
                $query = "SELECT value, time FROM log WHERE log.sensor = ? and log.time BETWEEN ? AND ?;";
                $stmt = $conn->prepare($query);
                $from = $_GET["dateFrom"]." 00:00:00";
                $to = $_GET["dateTo"]." 23:59:59";
                $stmt->bind_param("iss", $sensor["id"], $from, $to);
                $stmt->execute();
                $sensors = $stmt->get_result();
                while($row = $sensors->fetch_assoc()) {
                    $data[] = $row;
                }
                $sensor["data"] = $data;
                $sensors_data[]=$sensor;
            }

            $section->sensors = $sensors_data;
            $section->time=$t;
            echo json_encode($section);

            return;
        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(["err" => "Neboli zadané povinné údaje!"]);
            return;
        }

        //get section
    } elseif(isset($_GET["sectionId"])){
        //get section
        //get unit
        $query = "SELECT section.id, section.name, unit.id as unitId, unit.name as unitName FROM section join unit on section.unit = unit.id WHERE section.id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['sectionId']);
        $stmt->execute();
        $result = $stmt->get_result();
        $section = mysqli_fetch_object($result);
        if(is_null($section)){
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(["err" => "Požadovaná sekcia sa nenašla!"]);
            return;
        }
        $section->time=$t;

        //select all sensors with last value
        $query = "SELECT sensor.id, sensor.name, sensor.type, log.value, log.time
                    FROM sensor
                    JOIN (
                      SELECT sensor, MAX(time) AS max_time
                      FROM log
                      GROUP BY sensor
                    ) latest_logs
                    ON sensor.id = latest_logs.sensor
                    JOIN log
                    ON log.sensor = latest_logs.sensor
                    AND log.time = latest_logs.max_time
                    WHERE ((sensor.unit = ? AND sensor.section is null) OR sensor.section = ?) AND not sensor.type = 'water';";
        $stmt = $conn->prepare($query);
        try{
            $stmt->bind_param("ii", $section->unitId, $section->id);
        } catch (Exception $e){
            var_dump($e);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $section->sensors = [];
        while($row = $result->fetch_assoc()) {
            $section->sensors[] = $row;
        }

        echo json_encode($section);

    }else{
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode(["err" => "Neboli zadané povinné údaje!"]);
        return;
    }
}
