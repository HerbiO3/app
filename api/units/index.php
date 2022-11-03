<?php

//$unit1 = new stdClass();
//$unit1->name = "FAKULTA CHODBA";
//$unit1->id = 165;
//$unit2 = new stdClass();
//$unit2->name = "MATÚŠ JOKAY";
//$unit2->id = 225;
//
//$units = [$unit1, $unit2];
//
//echo json_encode($units);


header('Content-Type: application/json; charset=utf-8');

//GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //Get by id
//    sleep(1);
    if(isset($_GET["unitId"])){
        if(intval($_GET["unitId"]) == 5){
            echo '{ "name":"Fakulta chodba", "id":5, "sections":[ { "id": 5, "name": "Kvetináč 1", "unitName": "Fakulta chodba" }, { "id": 2, "name": "Kvetináč 2", "unitName": "Fakulta chodba" }, { "id": 3, "name": "Kvetináč 3", "unitName": "Fakulta chodba" } ] }';
            return;
        }else{
            header("HTTP/1.1 404 NOT FOUND");
            echo json_encode(["err" => "Požadovaná jednotka sa nenašla!"]);
            return;
        }
    //get all
    } else{
        echo '[ { "id": 5, "name": "Fakulta chodba" }, { "id": 2, "name": "Matúš Jokay" } ]';
        return;
    }
}
