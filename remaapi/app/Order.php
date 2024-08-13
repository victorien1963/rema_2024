<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "cpp_shop_order";
    protected $primaryKey = 'orderid';
}
