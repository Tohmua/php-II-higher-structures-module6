<?php

namespace spec\App\PreparedStatements;

use App\Database\PDODatabase;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductsSpec extends ObjectBehavior
{
    public function let()
    {
        $db = new PDODatabase();
        $this->beConstructedWith($db);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('App\PreparedStatements\Products');
    }

    public function it_should_build_query_with_1_param()
    {
        $this->buildQuery(['a' => 1])->shouldReturn(
            'SELECT name, price, description FROM products WHERE `a` = ?'
        );
    }

    public function it_should_build_query_with_2_params()
    {
        $this->buildQuery(['a' => 1, 'b' => 1])->shouldReturn(
            'SELECT name, price, description FROM products WHERE `a` = ? AND `b` = ?'
        );
    }

    public function it_should_build_query_with_3_params()
    {
        $this->buildQuery(['a' => 1, 'b' => 1, 'c' => 3])->shouldReturn(
            'SELECT name, price, description FROM products WHERE `a` = ? AND `b` = ? AND `c` = ?'
        );
    }
}
