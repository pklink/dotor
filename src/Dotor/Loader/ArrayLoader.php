<?php


namespace Dotor\Loader;


use Dotor\Loader;

class ArrayLoader implements Loader
{

    private $config = [];

    /**
     * @param array $config
     * @return ArrayLoader
     */
    public static function create($config = [])
    {
        $instance = new ArrayLoader();
        $instance->load($config);
        return $instance;
    }

    /**
     * @param array $config
     */
    public function load($config = [])
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->config;
    }
}
