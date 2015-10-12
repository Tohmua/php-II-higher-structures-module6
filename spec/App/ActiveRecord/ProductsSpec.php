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
        $dbStatement->execute([1])->willReturn(true);
        $dbStatement->fetch(\PDO::FETCH_ASSOC)->willReturn(['id' => 1, 'name' => 'test', 'price' => 1099, 'description' => 'some test data']);

        $db->prepare('INSERT INTO `products`(`name`, `price`, `description`) VALUES (?, ?, ?)')->willReturn($dbStatement);
        $db->prepare('SELECT `id`, `name`, `price`, `description` FROM `products` WHERE `id` = ?')->willReturn($dbStatement);

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

    public function it_cant_load_based_on_fields_that_arnt_part_of_the_model()
    {
        $this->shouldThrow('App\ActiveRecord\ModelException')->during('load', [['foo' => 'bar']]);
    }

    public function it_can_load_a_product_with_id_1()
    {
        $this->load(['id' => 1]);
        $this->name->shouldReturn('test');
        $this->price()->shouldReturn('10.99');
        $this->description->shouldReturn('some test data');
    }
}
