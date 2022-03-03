<?php

require 'vendor/autoload.php';

use Onetoweb\Kvk\Client;

// params
$apiKey = 'api_key';
$testModus = true;

// get kvk client
$client = new Client($apiKey, $testModus);

// search companies
$results = $client->searchCompanies([
    'kvkNumber' => '42',
]);

// profile companies
$results = $client->profileCompanies([
    'kvkNumber' => '42',
]);
