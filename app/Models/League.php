<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    //
    use HasFactory;
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    protected $fillable = [
        'description',
    ];
}
