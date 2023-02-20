<?php

namespace App\Http\Livewire;

use App\Models\User;
use Auth;
use DB;
use Livewire\Component;
use Route;

class EmployeeSelector extends Component
{
    public $search = "";
    public $leaders = [];
    public $members = [];
    public $ids = [];
    public $is_admin = true;
    public $alreadyChosenIds = [];

    public function mount($group_id)
    {
        
        $this->is_admin = Auth::user()->can('manage-groups');
        
        if($group_id != null) {
            $isGroup = str_contains(Route::getCurrentRoute()->uri(), "group") == true;
            $userIds = [];

            if($isGroup) {
                $userIds = DB::table('group_user')->where('group_id', '=', $group_id)->pluck('user_id')->toArray();
            } else {
                $userIds = DB::table('department_user')->where('department_id', '=', $group_id)->pluck('user_id')->toArray();
            }

            $this->alreadyChosenIds = array_merge($this->alreadyChosenIds, $userIds);
        }
    }

    public function render()
    {
        $users = [];

        $alreadyChosenIds = $this->alreadyChosenIds;
        foreach ($this->leaders as $leader) {
            array_push($alreadyChosenIds, $leader['id']);
        }
        
        foreach ($this->members as $member) {
            array_push($alreadyChosenIds, $member['id']);
        }
        $alreadyChosenIds = array_values($alreadyChosenIds);
        $this->ids = $alreadyChosenIds;

        $users = User::search($this->search)->role('employee')->whereNotIn('id', $alreadyChosenIds)->get();

        return view('livewire.employee-selector', [
            'users' => $users,
            'leaders' => $this->leaders,
            'members' => $this->members,
            'ids' => $alreadyChosenIds,
        ]);
    }

    public function addLeader(User $user)
    {
        array_push($this->leaders, $user->toArray());
    }

    public function addMember(User $user)
    {
        array_push($this->members, $user->toArray());
    }

    public function removeLeader(int $index)
    {
        array_splice($this->leaders, $index, 1);
    }

    public function removeMember(int $index)
    {
        array_splice($this->members, $index, 1);
    }

    public function demoteLeader(int $index)
    {
        // Get the element to transfer
        $element = $this->leaders[$index];

        // Remove the element from the $this->leaders array
        array_splice($this->leaders, $index, 1);

        // Add the element to the $this->members array
        array_push($this->members, $element);
    }

    public function promoteLeader(int $index)
    {
        // Get the element to transfer
        $element = $this->members[$index];

        // Remove the element from the $this->leaders array
        array_splice($this->members, $index, 1);

        // Add the element to the $this->members array
        array_push($this->leaders, $element);
    }
}
