<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLocationDetails extends Model
{
    protected $fillable = ['order_id', 'user_lat', 'user_long', 'vendor_lat', 'vendor_long', 'rider_lat', 'rider_long'];
}
