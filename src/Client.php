<?php

namespace Onetoweb\Kvk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use DateTime;

/**
 * Kvk Api v2 client.
 *
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
class Client
{
    /**
     * Base Uris
     */
    const BASE_URI_LIVE = 'https://api.kvk.nl/api/v2/';
    const BASE_URI_TEST = 'https://api.kvk.nl/api/v2/test';
    
    /**
     * @var string
     */
    private $apiKey;
    
    /**
     * @var bool
     */
    private $testModus;
    
    /**
     * @param string $apiKey
     * @param bool $testModus = false
     */
    public function __construct(string $apiKey, bool $testModus = false)
    {
        $this->apiKey = $apiKey;
        $this->testModus = $testModus;
    }
    
    /**
     * @return string
     */
    private function getBaseUri(): string
    {
        if ($this->testModus) {
            return self::BASE_URI_TEST;
        } else {
            return self::BASE_URI_LIVE;
        }
    }
    
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function searchCompanies(array $query = []): ?array
    {
        return $this->request('search/companies', $query);
    }
    
    /**
     * @param array $query = []
     * 
     * @return array
     */
    public function profileCompanies(array $query = []): ?array
    {
        return $this->request('profile/companies', $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return array
     */
    public function request(string $endpoint, array $query = []): ?array
    {
        // add user key to query
        $query['user_key'] = $this->apiKey;
        
        // build options
        $options = [
            RequestOptions::QUERY => $query,
            RequestOptions::VERIFY => false,
            RequestOptions::IDN_CONVERSION => false,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Strict-Transport-Security' => 'Strict-Transport-Security'
            ],
        ];
        
        // get guzzle client
        $guzzleClient = new GuzzleClient([
            'http_errors' => false,
        ]);
        
        // make request
        $response = $guzzleClient->request('GET', $this->getBaseUri() . $endpoint, $options);
        
        // get contents
        $contents = $response
            ->getBody()
            ->getContents()
        ;
        
        return json_decode($contents, true);
    }
}