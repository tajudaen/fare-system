<?php

require_once("vendor/autoload.php");

use fare\BusFareSystem;
use fare\SubwayFareSystem;

try {
    $client1 = new BusFareSystem();
    $client1->loadCard(3);

    $client1->startTrip("Pelham Parkway");
    $client1->endTrip("Bronx");
    print $client1->getSummary();
    echo '<br>';
} catch (Exception $e) {
    echo $e->getMessage();
}


try {
    $client2 = new SubwayFareSystem();
    $client2->loadCard(30);
    $client2->startTrip("Bronx");
    $client2->endTrip("5th");
    print $client2->getSummary();
} catch (Exception $e) {
    echo $e->getMessage();
}