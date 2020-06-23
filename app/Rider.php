<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $fillable = ['first_name', 'last_name', 'profile_picture', 'address', 'phone_number', 'email', 'age', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
