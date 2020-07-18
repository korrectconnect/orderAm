<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Rider extends Authenticatable
{
    protected $table = 'riders';

    protected $fillable = ['firstname', 'lastname', 'email', 'category', 'phone', 'company', 'state', 'lga', 'country', 'address', 'spouse_name', 'spouse_phone',
    'date_of_birth', 'plate_number', 'active', 'location_assigned', 'location_description', 'image', 'username'];

    protected $hidden = [
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
