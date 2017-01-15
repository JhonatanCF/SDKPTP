<?php

namespace JhonatanCF5\Model;

use JhonatanCF5\Helpers\Helper;

class ModelPlaceToPay
{
    protected $attributes = [];

    public function __construct(array $attributes = array())
    {
        if(is_array($attributes)) {
            $this->attributes = $attributes;
        }
    }

    public function setAttribute($name, $value)
    {
        $customSetter = 'set'.Helper::studly($name).'Attribute';

        if (method_exists($this, $customSetter)) {
            return $this->$customSetter($value);
        }

        $this->attributes[$name] = $value;

        return $this;
    }

    public function getAttribute($name)
    {
        $customGetter = 'get'.Helper::studly($name).'Attribute';

        $value = array_key_exists($name, $this->attributes)
            ? $this->attributes[$name]
            : null;

        if (method_exists($this, $customGetter)) {
            return $this->$customGetter($value);
        }

        return $value;
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }
}
