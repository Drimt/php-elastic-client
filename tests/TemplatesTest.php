<?php

namespace Drimt\ElasticClient;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

/**
 * Description of ElasticClientTest
 *
 * @author tibo
 */
class TemplatesTest extends TestCase
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
    
    public function testGetAll()
    {
        $templates = $this->client()->templates()->all();
        $this->assertEquals("logs-apm.error@template", $templates[0]->name);
        $this->assertEquals(98, count($templates));
    }
    
    public function testCreateDelete()
    {
        $templates = $this->client()->templates();
        $templates->create("p1sensor", file_get_contents(__DIR__ . "/template.txt"));
        $this->assertEquals(99, count($templates->all()));
        
        $template_p1sensor = $templates->name("p1sensor");
        $this->assertEquals("p1sensor-*", $template_p1sensor->index_patterns[0]);
        $template_p1sensor->delete();
    }
}
