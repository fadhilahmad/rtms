<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // table name and primary key
    protected $table = 'order';
    protected $primaryKey = 'o_id';
}
