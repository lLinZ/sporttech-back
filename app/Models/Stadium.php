<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    public function locations()
    {
        return $this->hasMany(Location::class);
    }
    //
    protected $table = 'stadiums';
    protected $fillable = [
        'description',
    ];
}
