<?php

namespace Onetoweb\Kvk;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Onetoweb\Kvk\Config\BaseUri;

/**
 * Kvk Search Api Client.
 *
 * @author Jonathan van 't Ende <jvantende@onetoweb.nl>
 * @copyright Onetoweb B.V.
 */
class Client
{
    /**
     * @param string $apiKey
     * @param bool $testModus = false
     */
    public function __construct(
        
        #[\SensitiveParameter]
        private string $apiKey,
        
        private bool $testModus = false
    ) {
        
    }
    
    /**
     * @return string
     */
    private function getBaseUri(): string
    {
        if ($this->testModus) {
            return BaseUri::TEST->value;
        } else {
            return BaseUri::LIVE->value;
        }
    }
    
    /**
     * @param array $query = []
     *
     * @return array|null
     */
    public function search(array $query = []): ?array
    {
        return $this->request('zoeken', $query);
    }
    
    /**
     * @param string $endpoint
     * @param array $query = []
     * 
     * @return array|null
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
            RequestOptions::HTTP_ERRORS => false,
        ]);
        
        // make request
        $response = $guzzleClient->get($this->getBaseUri() . $endpoint, $options);
        
        // get contents
        $contents = $response
            ->getBody()
            ->getContents()
        ;
        
        return json_decode($contents, true);
    }
}
