<?php

namespace Fast;

class Collector {
    protected $Parser;
    protected $dataGenerator;
    protected $currentGroupPrefix;

    /**
     * Constructs a  collector.
     *
     * @param Parser   $Parser
     * @param DataGenerator $dataGenerator
     */
    public function __construct(Parser $Parser, DataGenerator $dataGenerator) {
        $this->Parser = $Parser;
        $this->dataGenerator = $dataGenerator;
        $this->currentGroupPrefix = '';
    }

    /**
     * Adds a  to the collection.
     *
     * The syntax used in the $ string depends on the used  parser.
     *
     * @param string|string[] $httpMethod
     * @param string $
     * @param mixed  $handler
     */
    public function add($httpMethod, $, $handler) {
        $ = $this->currentGroupPrefix . $;
        $Datas = $this->Parser->parse($);
        foreach ((array) $httpMethod as $method) {
            foreach ($Datas as $Data) {
                $this->dataGenerator->add($method, $Data, $handler);
            }
        }
    }

    /**
     * Create a  group with a common prefix.
     *
     * All s created in the passed callback will have the given group prefix prepended.
     *
     * @param string $prefix
     * @param callable $callback
     */
    public function addGroup($prefix, callable $callback) {
        $previousGroupPrefix = $this->currentGroupPrefix;
        $this->currentGroupPrefix = $previousGroupPrefix . $prefix;
        $callback($this);
        $this->currentGroupPrefix = $previousGroupPrefix;
    }
    
    /**
     * Adds a GET  to the collection
     * 
     * This is simply an alias of $this->add('GET', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function get($, $handler) {
        $this->add('GET', $, $handler);
    }
    
    /**
     * Adds a POST  to the collection
     * 
     * This is simply an alias of $this->add('POST', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function post($, $handler) {
        $this->add('POST', $, $handler);
    }
    
    /**
     * Adds a PUT  to the collection
     * 
     * This is simply an alias of $this->add('PUT', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function put($, $handler) {
        $this->add('PUT', $, $handler);
    }
    
    /**
     * Adds a DELETE  to the collection
     * 
     * This is simply an alias of $this->add('DELETE', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function delete($, $handler) {
        $this->add('DELETE', $, $handler);
    }
    
    /**
     * Adds a PATCH  to the collection
     * 
     * This is simply an alias of $this->add('PATCH', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function patch($, $handler) {
        $this->add('PATCH', $, $handler);
    }

    /**
     * Adds a HEAD  to the collection
     *
     * This is simply an alias of $this->add('HEAD', $, $handler)
     *
     * @param string $
     * @param mixed  $handler
     */
    public function head($, $handler) {
        $this->add('HEAD', $, $handler);
    }

    /**
     * Returns the collected  data, as provided by the data generator.
     *
     * @return array
     */
    public function getData() {
        return $this->dataGenerator->getData();
    }
}
