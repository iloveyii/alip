<?php
namespace App\models;

class Response
{
    private $type;
    private $info = [
        'departureAirport' => '',
        'departureDate' => '',
        'arrivalAirport' => '',
        'arrivalDate' => '',

        'childrenCount' => 0,
        'adultsCount' => 1,
        'infantCount' => 0
    ];

    public function __construct($type)
    {
    }
}
