<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    // table name and primary key
    protected $table = 'price';
    protected $primaryKey = 'p_id';
}
