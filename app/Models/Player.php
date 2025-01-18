<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
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
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // discipline_id	category_id	league_id	team_id	status_id
    protected $fillable = [
        'names',
        'surnames',
        'email',
        'document',
        'photo',
    ];
}
