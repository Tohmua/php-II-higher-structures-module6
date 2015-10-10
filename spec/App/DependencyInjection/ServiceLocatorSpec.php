<?php

namespace spec\App\DependencyInjection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceLocatorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('App\DependencyInjection\ServiceLocator');
    }

    public function it_returns_set_object_instance()
    {
        $foo = new \stdClass();
        $this->set('class', $foo);
        $this->get('class')->shouldReturn($foo);
    }

    public function it_returns_set_array_instance()
    {
        $foo = ['foo' => 'bar'];
        $this->set('array', $foo);
        $this->get('array')->shouldReturn($foo);
    }

    public function it_should_not_accept_more_than_one_set_with_the_same_name()
    {
        $this->set('same', []);
        $this->shouldThrow('App\DependencyInjection\ServiceLocatorException')->during('set', ['same', new \stdClass()]);
    }

    public function it_should_not_get_unset_service()
    {
        $this->shouldThrow('App\DependencyInjection\ServiceLocatorException')->during('get', ['not_a_service']);
    }
}
