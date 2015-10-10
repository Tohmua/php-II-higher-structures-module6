<?php

namespace App\DependencyInjection;

interface ServiceLocatorInterface
{
    public function set($name, $service);

    public function get($name);

    public function has($name);
}
