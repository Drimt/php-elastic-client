<?php

namespace Drimt\ElasticClient;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

/**
 * Description of ElasticClientTest
 *
 * @author tibo
 */
class ElasticClientTest extends TestCase
{
    
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
        $dotenv->load();
    }
    
    public function client() : ElasticClient
    {
        return new ElasticClient("http://127.0.0.1:9200", "elastic", $_ENV["ES_PASSWORD"]);
    }
    
    public function testSetUserPassword()
    {
        $result = $this->client()->post(
            "/_security/user/kibana_system/_password",
            ['password' => $_ENV["KIBANA_PASSWORD"]]
        );
    }
    
    public function testCreateListDeleteAPIKey()
    {
        $count = count($this->client()->keys()->active());
        $this->client()->keys()->create("my-test-key");
        $this->assertEquals($count + 1, count($this->client()->keys()->active()));
        
        foreach ($this->client()->keys()->active() as $key) {
            $key->delete();
        }
        
        $this->assertEquals(0, count($this->client()->keys()->active()));
    }
}
