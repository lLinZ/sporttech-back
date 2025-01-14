<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
    protected $fillable = [
        'description',
        'impact',
        'author',
    ];
}
