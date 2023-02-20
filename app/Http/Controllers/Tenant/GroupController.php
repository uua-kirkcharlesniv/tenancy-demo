<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use DB;
use Illuminate\Http\Request;
use Redirect;

class GroupController extends Controller
{
    public function index()
    {
        return view('groups.index')->with('data', Group::all());
    }

    public function create(GroupRequest $request)
    {
        $group = Group::create([
            'name' => $request->validated('name'),
        ]);

        $masterlist = [];

        $leaders = $request->validated('leader');
        if($leaders != null) {
            foreach ($leaders as $leader) {
                $masterlist[$leader] = ['is_leader' => true];
            }
        }

        $members = $request->validated('member');
        if($members != null) {
            foreach ($members as $member) {
                $masterlist[$member] = ['is_leader' => false];
            }
        }
        
        $group->members()->attach($masterlist);

        return Redirect::route('tenant.groups.index')->with('status', 'group-created');
    }

    public function view(int $id)
    {
        return view('groups.view')->with('data', Group::findOrFail($id));
    }

    public function delete(int $id)
    {
        $group = Group::findOrFail($id);
        $group->members()->detach();
        $group->delete();

        return Redirect::route('tenant.groups.index')->with('status', 'group-deleted');
    }

    public function update(int $id, GroupRequest $request)
    {
        $group = Group::findOrFail($id);
        $group->update($request->validated());

        $masterlist = [];

        $leaders = $request->validated('leader');
        if($leaders != null) {
            foreach ($leaders as $leader) {
                $masterlist[$leader] = ['is_leader' => true];
            }
        }

        $members = $request->validated('member');
        if($members != null) {
            foreach ($members as $member) {
                $masterlist[$member] = ['is_leader' => false];
            }
        }
        
        $group->members()->attach($masterlist);

        return Redirect::route('tenant.groups.view', $id)->with('status', 'group-updated');
    }

    public function removeFromGroup(int $groupId, int $memberId)
    {
        DB::table('group_user')->where('group_id', '=', $groupId)->where('user_id', '=', $memberId)->delete();

        return Redirect::route('tenant.groups.view', $groupId)->with('status', 'group-updated');
    }
}
