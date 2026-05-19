<?php

namespace Drimt\ElasticClient;

/**
 *
 *
 * @author tibo
 */
class Templates extends Store
{
    
    /**
     * List all templates.
     * @return array<Template>
     */
    public function all() : array
    {
        $result = $this->client()->get("/_index_template");
        
        if (! isset($result->index_templates)) {
            return [];
        }
        
        $a = [];
        foreach ($result->index_templates as $template_json) {
            $template = Template::fromStdClass($template_json->index_template, $this->client());
            $template->name = $template_json->name;
            $a[] = $template;
        }
        return $a;
    }
    
    /**
     * Get a single template by name.
     *
     * @param string $name
     * @return Template|null
     */
    public function name(string $name) : ?Template
    {
        $result = $this->client()->get("/_index_template/$name");
        if (! isset($result->index_templates)) {
            return null;
        }
        $template_json = $result->index_templates[0];
        
        $template = Template::fromStdClass($template_json->index_template, $this->client());
        $template->name = $template_json->name;
        
        return $template;
    }
    
    /**
     * Create an index template.
     * @param string $name
     * @param string $json
     */
    public function create(string $name, string $json)
    {
        $this->client()->json("/_index_template/$name", $json, "PUT");
    }
}
