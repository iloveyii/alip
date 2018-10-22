<?php
namespace App\nterfaces;

/**
 * Interface for parsing the data from OTA
 */
Interface Parser
{
    public function getFeedType($domain);
    public function getResult();
    public function getOtaUrl();

}
