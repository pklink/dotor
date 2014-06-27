<?php


namespace Dotor\Loader;


use Dotor\Loader;

class ArrayLoader implements Loader
{

    private $config = [];

    /**
     * @return array
     */
    public function get()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function load($config = [])
    {
        $this->config = $config;
    }
}
