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
     * @param string $path
     * @return ArrayLoader
     */
    public static function createFromFile($path)
    {
        $instance = new ArrayLoader();
        $instance->loadFromFile($path);
        return $instance;
    }

    /**
     * @param string $path
     * @throws Exception\FileNotReturnAnArrayException
     * @throws Exception\FileIsNotReadableException
     */
    public function loadFromFile($path)
    {
        if (!is_readable($path)) {
            throw new Loader\Exception\FileIsNotReadableException();
        }

        $config = include($path);

        if (!is_array($config)) {
            throw new Loader\Exception\FileNotReturnAnArrayException();
        }

        $this->load($config);
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->config;
    }
}
