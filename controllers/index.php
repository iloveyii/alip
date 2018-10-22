<?php
require __DIR__ . '/../vendor/autoload.php';

use App\models;

$oneWay= 1;
$tripType = ($oneWay == 1) ? "ROUNDTRIP" : "ONEWAY";
$from = 'ARN';
$to = 'ATH';
$departureYear = 2016;
$departureMonth = 06;
$departureDay = 12;

$returnDay = 11;
$returnMonth = 7;
$returnYear = 2016;

$childrenCount = 0;
$adultsCount = 1;
$infantCount = 0;

    $agent1 = new models\Airngo(
        $tripType, $from, $to, $departureYear, $departureMonth, $departureDay,
        $returnDay,
        $returnMonth, $returnYear, $childrenCount, $adultsCount, $infantCount
    );

    $d = $agent1->getResult();

    echo json_encode($d);

// echo $agent1->getOtaUrl();
