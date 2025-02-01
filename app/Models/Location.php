<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
    //
    protected $fillable = [
        'description',
    ];
}
