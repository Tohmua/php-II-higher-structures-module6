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

    public function it_should_not_be_constructed_witout_a_dsn()
    {
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('connect', [[]]);
    }

    public function it_should_not_be_constructed_witout_a_username()
    {
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('connect', [['dsn' => 'a']]);
    }

    public function it_should_not_be_constructed_witout_a_password()
    {
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('connect', [['dsn' => 'a', 'username' => 'foo']]);
    }

    public function it_should_not_connect_with_invalid_credentials()
    {
        $this->shouldThrow('App\Database\DatabaseConnectionException')
             ->during('connect', [['dsn' => 'a', 'username' => 'foo', 'password' => 'bar']]);
    }
}
