<?php

namespace spec\App\ActiveRecord;

use App\Database\PDODatabase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;

class ProductsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith($this->mockDb());
    }

    private function mockDb()
    {
        $prophet = new Prophet();
        $db = $prophet->prophesize('App\Database\PDODatabase');
        $db->willImplement('App\Database\Database');

        $dbStatement = $prophet->prophesize('PDOStatement');
        $dbStatement->execute(["test", 1099, "test text"])->willReturn(true);

        $db->prepare('INSERT INTO `products`(`name`, `price`, `description`) VALUES (?, ?, ?)')->willReturn($dbStatement);

        return $db->reveal();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\ActiveRecord\Products');
    }

    public function it_should_be_able_to_set_id()
    {
        $this->id = 1;
        $this->id->shouldReturn(1);
    }

    public function it_should_be_able_to_set_name()
    {
        $this->name = 'Boo';
        $this->name->shouldReturn('Boo');
    }

    public function it_should_be_able_to_set_price()
    {
        $this->price = 'Boo';
        $this->price->shouldReturn('Boo');
    }

    public function it_should_be_able_to_set_description()
    {
        $this->description = 'Boo';
        $this->description->shouldReturn('Boo');
    }

    public function it_should_not_be_possible_to_set_foo()
    {
        $this->shouldThrow('App\ActiveRecord\ModelException')->foo = 'Boo';
    }

    public function it_should_format_price()
    {
        $this->price = 1099;
        $this->price()->shouldReturn('10.99');
    }

    public function it_should_save_price()
    {
        $this->name = 'test';
        $this->price = 1099;
        $this->description = 'test text';

        $this->save()->shouldReturn(true);
    }
}
