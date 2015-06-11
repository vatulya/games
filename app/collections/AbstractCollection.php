<?php

namespace Games\Collection;

abstract class AbstractCollection extends \Phalcon\Mvc\Collection
{

    public function __set($property, $value) {
        $method = 'set' . ucfirst($property);
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->$property = $value;
        }
    }

    public function __get($property) {
        $method = 'get' . ucfirst($property);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return $this->$property;
        }
    }

}