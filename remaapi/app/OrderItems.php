<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = "cpp_shop_orderitems";
    protected $primaryKey = 'id';
}
