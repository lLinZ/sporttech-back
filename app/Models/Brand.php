<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function client()
    {
        return $this->hasMany(Client::class);
    }
    protected $fillable = [
        'description',
        'photo',
        'bio',
    ];
}
