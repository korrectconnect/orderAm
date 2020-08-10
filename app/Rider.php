<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    protected $table = 'riders';
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    protected $fillable = ['firstname', 'lastname', 'email', 'category', 'phone', 'company', 'state', 'lga', 'country', 'address', 'spouse_name', 'spouse_phone',
    'date_of_birth', 'plate_number', 'active', 'location_assigned', 'location_description', 'image', 'username'];
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    protected $hidden = [
        'password',
    ];
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
