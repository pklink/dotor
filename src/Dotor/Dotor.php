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
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($param = null, $default = null)
    {
        // $param has to be a string or integer
        if (!is_string($param) && !(is_int($param)) && $param !== null)
        {
            throw new \InvalidArgumentException('$param has to be a string, integer or null');
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


    /**
     * @param string|int|null $param
     * @param mixed $default a scalar value
     * @return mixed a scalar value
     * @throws \InvalidArgumentException
     */
    public function getScalar($param = null, $default = '')
    {
        $value = $this->get($param, $default);

        // check if $param is scalar
        if (!is_scalar($value))
        {
            // check if $default is scalar
            if (!is_scalar($default))
            {
                throw new \InvalidArgumentException('$default has to be scalar');
            }

            return $default;
        }
        else
        {
            return $value;
        }
    }

}
