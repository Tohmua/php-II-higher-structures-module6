<?php

namespace App\ActiveRecord;

use App\ActiveRecord\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fields = ['id', 'name', 'price', 'description'];

    public function price()
    {
        return number_format($this->price / 100, 2, '.', ',');
    }
}
