<?php

namespace Drimt\ElasticClient;

/**
 * An abstract class to group common methods for all stores (e.g. keys, templates etc.)
 *
 * @author tibo
 */
abstract class Store
{
    /**
     *
     * @var ElasticClient
     */
    private $client;
    
    public function __construct(ElasticClient $client)
    {
        $this->client = $client;
    }
    
    public function client() : ElasticClient
    {
        return $this->client;
    }
}
