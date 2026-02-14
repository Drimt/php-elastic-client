<?php

namespace Drimt\ElasticClient;

/**
 *
 *
 * @author tibo
 */
class Keys
{
    private $client;
    
    public function __construct(ElasticClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * List all active (not invalidated) API keys.
     * @return array
     */
    public function active() : array
    {
        return array_filter($this->all(), fn(Key $key) => ! $key->invalidated);
    }
    
    /**
     * List all valid (not deleted) API keys.
     * @return array<Key>
     */
    public function all() : array
    {
        // ?invalidated=false
        $result = $this->client->get("/_security/api_key");
        if (! isset($result->api_keys)) {
            return [];
        }
        
        $a = [];
        foreach ($result->api_keys as $key) {
            $a[] = Key::fromStdClass($key, $this->client);
        }
        return $a;
    }
    
    /**
     * Create an API key and return the secret token.
     * @param string $name
     */
    public function create(string $name) : string
    {
        return $this->client->post("/_security/api_key", ["name" => $name])->api_key;
    }
}
