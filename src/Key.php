<?php

namespace Drimt\ElasticClient;

/**
 * API key.
 *
 * @author tibo
 */
class Key
{
    
    public string $id;
    public string $name;
    public string $type;
    public int $creation;
    public bool $invalidated;
    public string $username;
    public string $realm;
    public string $realm_type;
    public object $metadata;
    public object $role_descriptors;
    
    private ElasticClient $client;


    public static function fromStdClass(\stdClass $in, ElasticClient $client): self
    {
        $out = new self();
        $reflection = new \ReflectionObject($in);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();
            if (property_exists(self::class, $name)) {
                $out->$name = $in->$name;
            }
        }
        
        $out->client = $client;
        
        return $out;
    }
    
    /**
     *
     * @see https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-security-invalidate-api-key
     */
    public function delete()
    {
        return $this->client->delete("/_security/api_key", ['ids' => $this->id]);
    }
}
