<?php

namespace Games\Model;

/**
 * @method array toArray
 */
abstract class AbstractModel extends \Phalcon\Mvc\Model
{

    public function __set($property, $value) {
        $method = 'set' . ucfirst($property);
        if (method_exists($this, $method)) {
            return $this->$method($value);
        }
        if (property_exists($this, $property)) {
            $this->$property = $value;

            return $value;
        }
        throw new \RuntimeException('Can\'t set property "' . $property . '" in model "' . get_class($this) . '"');
    }

    public function __get($property) {
        $method = 'get' . ucfirst($property);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new \RuntimeException('Can\'t get property "' . $property . '" from model "' . get_class($this) . '"');
    }

}