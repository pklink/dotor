<?php

namespace Dotor;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license BSD-2-Clause http://opensource.org/licenses/BSD-2-Clause See LICENSE-file in root directory
 */
class Dotor
{

    /**
     * @var array
     */
    protected $params = [];


    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->params = $config;
    }


    /**
     * @param string|int|null $param
     * @param null $default
     * @return array|null|string
     * @throws \InvalidArgumentException
     */
    public function get($param = null, $default = null)
    {
        // $param must be a string or integer
        if (!is_string($param) && !(is_int($param)) && $param !== null)
        {
            throw new \InvalidArgumentException('$param must be a string, integer or null');
        }

        // if param is null get the param-array
        if ($param === null)
        {
            return $this->params;
        }

        $source   = $this->params;

        // split $param
        $segments = explode('.', $param);

        // returned value
        $value = '';

        // iterate splitted $param
        foreach ($segments as $index => $segment)
        {
            // if param doesn't exist return default value
            if (!isset($source[$segment]))
            {
                return $default;
            }

            // save value
            $value = $source[$segment];

            if ($index < count($segments)-1)
            {
                $source = $value;
            }
        }

        return $value;
    }

}
