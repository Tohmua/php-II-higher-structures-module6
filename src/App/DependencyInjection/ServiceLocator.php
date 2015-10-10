<?php

namespace App\DependencyInjection;

use App\DependencyInjection\ServiceLocatorException;
use App\DependencyInjection\ServiceLocatorInterface;

class ServiceLocator implements ServiceLocatorInterface
{
    private $services = [];

    final public function set($name, $service)
    {
        if ($this->has($name)) {
            throw new ServiceLocatorException('AAAA');
        }

        $this->services[$name] = $service;
    }

    final public function get($name)
    {
        if (!$this->has($name)) {
            throw new ServiceLocatorException('AAAA');
        }

        return $this->services[$name];
    }

    final public function has($name)
    {
        return isset($this->services[$name]);
    }

    public function __toString()
    {
        return array_keys($this->services);
    }
}
