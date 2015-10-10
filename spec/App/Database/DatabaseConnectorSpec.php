<?php

namespace spec\App\Database;

use App\Database\PDODatabase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DatabaseConnectorSpec extends ObjectBehavior
{
    public function let()
    {
        $db = new PDODatabase();
        $this->beConstructedWith($db, ['dsn' => 'dsn', 'username' => 'root', 'password' => 'pa55word']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\Database\DatabaseConnector');
    }

    public function it_should_not_be_constructed_witout_a_dsn()
    {
        $db = new PDODatabase();
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('__construct', [$db, []]);
    }

    public function it_should_not_be_constructed_witout_a_username()
    {
        $db = new PDODatabase();
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('__construct', [$db, ['dsn' => 'a']]);
    }

    public function it_should_not_be_constructed_witout_a_password()
    {
        $db = new PDODatabase();
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('__construct', [$db, ['dsn' => 'a', 'username' => 'foo']]);
    }

    public function it_should_not_connect_with_invalid_credentials()
    {
        $db = new PDODatabase();
        $this->shouldThrow('App\Database\DatabaseCreationException')
             ->during('__construct', [$db, ['dsn' => 'a', 'username' => 'foo', 'password' => 'bar']]);
    }
}
