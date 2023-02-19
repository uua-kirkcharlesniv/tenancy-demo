<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'photo'];

    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('is_leader')
                    ->withTimestamps();
    }
}
