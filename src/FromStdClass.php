<?php

namespace Drimt\ElasticClient;

/**
 * Description of FromStdClass
 *
 * @author tibo
 */
trait FromStdClass
{
    private ElasticClient $client;
    
    public static function fromStdClass(\stdClass $in, ElasticClient $client): self
    {
        $out = new self();
        $out->parseStdClass($in);
        $out->client = $client;
        
        return $out;
    }
    
    public function parseStdClass(\stdClass $in)
    {
        $reflection = new \ReflectionObject($in);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();
            if (property_exists($this, $name)) {
                $this->$name = $in->$name;
            }
        }
    }
}
