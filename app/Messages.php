<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $fillable = ['from', 'to', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
