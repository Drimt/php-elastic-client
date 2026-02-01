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
    
    
    public function testSetUserPassword()
    {
        $client = new ElasticClient("http://127.0.0.1:9200", "elastic", $_ENV["ES_PASSWORD"]);
        $result = $client->post(
            "/_security/user/kibana_system/_password",
            ['password' => $_ENV["KIBANA_PASSWORD"]]
        );
        
        $this->assertEquals([], $result);
    }
}
