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
     * @param Loader|array $config
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            $this->params = $config;
        } elseif ($config instanceof Loader) {
            $this->params = $config->get();
        }
    }


    /**
     * @param string|int|null $param
     * @param mixed $default
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($param = null, $default = null)
    {
        // $param has to be a string or integer
        if (!is_string($param) && !(is_int($param)) && $param !== null) {
            throw new \InvalidArgumentException('$param has to be a string, integer or null');
        }

        // if param is null get the param-array
        if ($param === null) {
            return $this->params;
        }

        $source   = $this->params;

        // split $param
        $segments = explode('.', $param);

        // returned value
        $value = '';

        // iterate splitted $param
        foreach ($segments as $index => $segment) {
            // if param doesn't exist return default value
            if (!isset($source[$segment])) {
                return $default;
            }

            // save value
            $value = $source[$segment];

            if ($index < count($segments)-1) {
                $source = $value;
            }
        }

        return $value;
    }


    /**
     * Alias for Dotot::getBoolean
     *
     * @param string $param
     * @param boolean $default
     * @return boolean
     */
    public function getBool($param, $default = true)
    {
        return $this->getBoolean($param, $default);
    }


    /**
     * @param string $param
     * @param boolean $default
     * @return boolean
     */
    public function getBoolean($param, $default = true)
    {
        $value = $this->get($param, $default);

        // check if $value is boolean
        if (is_bool($value)) {
            return $value;
        } elseif ($value === '0' || $value === 0) {
            return false;
        } elseif ($value === '1' || $value === 1) {
            return true;
        } elseif (is_bool($default)) {
            return $default;
        } else {
            return true;
        }
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

        // check if $value is scalar
        if (!is_scalar($value)) {
            // check if $default is scalar
            if (!is_scalar($default)) {
                throw new \InvalidArgumentException('$default has to be scalar');
            }

            return $default;
        } else {
            return $value;
        }
    }


    /**
     * @param string|int|null $param
     * @param array $default
     * @return array
     */
    public function getArray($param = null, array $default = [])
    {
        $value = $this->get($param, $default);

        // check if $value is an array
        if (!is_array($value)) {
            return $default;
        } else {
            return $value;
        }
    }
}

