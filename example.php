<?php

require 'vendor/autoload.php';

use Onetoweb\Kvk\Client;

// params
$apiKey = 'api_key';
$testModus = false;

// get kvk client
$client = new Client($apiKey, $testModus);

// search
$results = $client->search([
    'kvkNummer' => '',
    'rsin' => '',
    'vestigingsnummer' => '',
    'handelsnaam' => '',
    'straatnaam' => '',
    'plaats' => '',
    'postcode' => '',
    'huisnummer' => '',
    'huisnummerToevoeging' => '',
    'type' => 'hoofdvestiging',
    'InclusiefInactieveRegistraties' => false,
    'pagina' => 1,
    'aantal' => 10,
]);
