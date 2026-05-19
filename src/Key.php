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


    use FromStdClass;
    
    /**
     *
     * @see https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-security-invalidate-api-key
     */
    public function delete()
    {
        return $this->client->delete("/_security/api_key", ['ids' => $this->id]);
    }
}
