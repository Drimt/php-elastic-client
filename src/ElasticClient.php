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
     *
     * @throws \RuntimeException
     */
    public function post(string $endpoint, array $payload)
    {
        $ch = curl_init($this->host . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_USERPWD => $this->username . ":" . $this->password,
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new \RuntimeException(curl_error($ch));
        }
        curl_close($ch);
        
        return json_decode($response, true);
    }
}
