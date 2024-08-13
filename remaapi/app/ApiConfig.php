<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiConfig extends Model
{
    protected $table = "cpp_api_config";
    protected $primaryKey = 'id';
    protected $fillable =['name','input_data', 'status', 'message'];
    public $timestamps = true;
}
