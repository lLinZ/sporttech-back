<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    //
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function league()
    {
        return $this->belongsTo(League::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'price',
        'description',
    ];
}
