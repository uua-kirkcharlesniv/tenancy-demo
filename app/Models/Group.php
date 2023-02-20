<?php

namespace App\Models;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'photo'];

    protected $appends = ['subtitle', 'is_logged_in_user_group_leader'];

    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('is_leader')
                    ->withTimestamps();
    }

    public function getSubtitleAttribute()
    {
        $leaders = [];
        $ordinary = [];

        $members = $this->members()->get();
        foreach ($members as $member) {
            if($member->pivot->is_leader) {
                array_push($leaders, $member->name);
            } else {
                array_push($ordinary, $member->name);
            }
        }

        $leaders = 'Lead by: ' . implode(', ', $leaders) . '.';
        $ordinary = 'Members: ' . implode(', ', $ordinary);
        return $leaders . ' ' . $ordinary;
    }

    public function getIsLoggedInUserGroupLeaderAttribute()
    {
        if(Auth::user() == null) {
            return false;
        }

        return DB::table('group_user')->where('group_id', '=', $this->id)->where('user_id', '=', Auth::user()->id)->where('is_leader', '=', true)->exists();
        
    }
}
