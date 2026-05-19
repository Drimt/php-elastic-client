<?php

namespace Drimt\ElasticClient;

/**
 * Index template.
 *
 * object(stdClass)#5290 (2) {
        ["name"]=>
        string(30) ".deprecation-indexing-template"
        ["index_template"]=>
        object(stdClass)#5291 (10) {
          ["index_patterns"]=>
          array(1) {
            [0]=>
            string(19) ".logs-deprecation.*"
          }
          ["composed_of"]=>
          array(2) {
            [0]=>
            string(30) ".deprecation-indexing-mappings"
            [1]=>
            string(30) ".deprecation-indexing-settings"
          }
          ["priority"]=>
          int(1000)
          ["version"]=>
          int(2)
          ["_meta"]=>
          object(stdClass)#5292 (2) {
            ["managed"]=>
            bool(true)
            ["description"]=>
            string(78) "default template for Stack deprecation logs index template installed by x-pack"
          }
          ["data_stream"]=>
          object(stdClass)#5293 (2) {
            ["hidden"]=>
            bool(true)
            ["allow_custom_routing"]=>
            bool(false)
          }
          ["allow_auto_create"]=>
          bool(true)
          ["deprecated"]=>
          bool(true)
          ["created_date_millis"]=>
          int(1770986651250)
          ["modified_date_millis"]=>
          int(1770986651250)
        }
      }
 * @author tibo
 */
class Template
{
    
    public string $name;
    public array $index_patterns;
    public object $template;
    public array $composed_of;
    public int $priority;
    public int $version;
    // phpcs:ignore PSR2.Classes.PropertyDeclaration.Underscore
    public object $_meta;
    public object $data_stream;
    public bool $allow_auto_create;
    public bool $deprecated;
    public int $created_date_millis;
    public int $modified_date_millis;


    use FromStdClass;
    
    /**
     *
     * @see https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-security-invalidate-api-key
     */
    public function delete()
    {
        return $this->client->delete("/_index_template/" . $this->name);
    }
}
