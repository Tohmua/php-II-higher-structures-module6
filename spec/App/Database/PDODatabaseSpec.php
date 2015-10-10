<?php

namespace spec\App\Database;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PDODatabaseSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\Database\PDODatabase');
    }

    public function it_should_not_connect_with_invalid_credentials()
    {
        $this->shouldThrow('App\Database\DatabaseCreationException')->during('connect', ['a', 'b', 'c']);
    }
}
