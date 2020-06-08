<?php

namespace ShadowFiend\Entities;

use GuzzleHttp\Psr7\Response;

class DndEntity
{
    /**
     * API endpoint
     * 
     * @var string
     */
    protected $endpoint;

    /**
     * @var GuzzleHttp\Client
     */
    protected $request;

    protected $query = [];

    protected $data = [];

    public function __construct(\GuzzleHttp\Client $request, string $endpoint = '')
    {
        if (!isset($this->endpoint)) {
            $this->endpoint = $endpoint;
        }
        
        $this->request = $request;
    }

    public function entity(string $index, array $query = [])
    {
        $this->data = $this->get($index, $query);

        return $this;
    }


    public function get($index = '', $query = [], $params = [])
    {
        $params = array_merge($params, ['query' => $query]);

        return $this->decode($this->request->get($this->endpoint . '/' . $index, $params));
    }

    public function query($key, $value)
    {
        $this->query[$key] = $value;

        return $this;
    }

    // Default behaviour is just a get request to list of items
    public function all($query = [])
    {
        if (!count($this->data) || $this->data === null) {
            $response = $this->get('', array_merge($this->query, $query));
        }        

        return $response['results'];
    }

    // Decode data
    protected function decode(Response $response)
    {
        $decoded = json_decode($response->getBody(), true);

        return $decoded === null || !is_array($decoded) ? [] : $decoded;
    }

    /**
     * Getter for data property
     * 
     * return @Array 
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * 
     * 
     */
    protected function getEntityIndexFromLastElementOfUrl(string $url)
    {
        $parts = explode('/', $url);

        return end($parts);
    }
}

