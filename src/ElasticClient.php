<?php

namespace Drimt\ElasticClient;

/**
 * Description of ElasticClient
 *
 * @author tibo
 */
class ElasticClient
{
    
    private string $host;
    private string $username;
    private string $password;
    
    public function __construct(string $host, string $username, string $password)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }
    

    /**
     *
     * @param string $endpoint
     * @param array $payload
     * @param string $method method to use (POST, GET, DELETE etc.)
     *
     * @throws \RuntimeException
     */
    private function query(string $endpoint, ?array $payload = null, string $method = "GET")
    {
        $ch = curl_init($this->host . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            //CURLOPT_POST => $post,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_USERPWD => $this->username . ":" . $this->password,
        ]);
        
        if (! is_null($payload)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new \RuntimeException(curl_error($ch));
        }
        curl_close($ch);
        
        return json_decode($response, false);
    }
    
    public function post(string $endpoint, array $payload)
    {
        return $this->query($endpoint, $payload, "POST");
    }
    
    public function get(string $endpoint, ?array $payload = null)
    {
        return $this->query($endpoint, $payload, "GET");
    }
    
    public function delete(string $endpoint, ?array $payload = null)
    {
        return $this->query($endpoint, $payload, "DELETE");
    }
    /**
     * Get an instance of API keys store.
     * @return Keys
     */
    public function keys() : Keys
    {
        return new Keys($this);
    }
}
