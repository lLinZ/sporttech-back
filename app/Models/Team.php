<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    use HasFactory;
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
    public function league()
    {
        return $this->belongsTo(League::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $fillable = [
        'description',
    ];
}
