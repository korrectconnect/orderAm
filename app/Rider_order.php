<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider_order extends Model
{
    protected $table = 'rider_orders';

    protected $fillable = ['rider_id', 'order_no', 'confirm'];
}
