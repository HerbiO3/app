<?php
header('Content-Type: application/json; charset=utf-8');

//GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Get section histroy
    if(isset($_GET["sectionId"]) && $_GET["history"]){
        if($_GET["dateFrom"] && $_GET["dateTo"]){
            echo '{ "id": 5, "name": "Kvetináč 1", "unitName": "Fakulta chodba", "waterLevel": 0.5, "uvIndex": 1, "airTemperature": 21, "humidity": [ { "sensorId": 3, "value":0.61 }, { "sensorId": 4, "value":0.63 } ], "tempHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":18 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":19 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":21 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":20 } ], "humidityHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.61 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.65 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.7 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.67 } ], "uvHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.6 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.7 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.5 } ], "levelHistory":[ { "timestamp":"2022-10-19T08:15:00.511Z", "value":0.6 }, { "timestamp":"2022-10-19T20:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-20T08:15:00.511Z", "value":0.5 }, { "timestamp":"2022-10-20T20:15:00.511Z", "value":0.4 } ], "wateringHistory":[ { "timestamp":"2022-10-19T09:15:00.511Z", "value":1 }, { "timestamp":"2022-10-19T09:20:00.511Z", "value":0 }, { "timestamp":"2022-10-20T09:15:00.511Z", "value":1 }, { "timestamp":"2022-10-20T09:20:00.511Z", "value":0 } ] }';
            return;
        }else{
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(["err" => "Neboli zadané povinné údaje!"]);
            return;
        }

        //get section
    } elseif(isset($_GET["sectionId"])){
        if($_GET["sectionId"] == 5){
            echo '{ "id": 5, "name": "Kvetináč 1", "unitName": "Fakulta chodba", "waterLevel": 0.5, "uvIndex": 1, "airTemperature": 21, "humidity": [ { "sensorId": 3, "value":0.61 }, { "sensorId": 4, "value":0.63 } ] }';
            return;
        }else{
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(["err" => "Požadovaná sekcia sa nenašla!"]);
            return;
        }
    }else{
        header("HTTP/1.1 400 BAD REQUEST");
        echo json_encode(["err" => "Neboli zadané povinné údaje!"]);
        return;
    }
}
