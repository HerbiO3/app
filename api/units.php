<?php

$unit1 = new stdClass();
$unit1->name = "FAKULTA CHODBA";
$unit1->id = 165;
$unit2 = new stdClass();
$unit2->name = "MATÚŠ JOKAY";
$unit2->id = 225;

$units = [$unit1, $unit2];

echo json_encode($units);
