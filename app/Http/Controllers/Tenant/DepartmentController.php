<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Department;
use DB;
use Illuminate\Http\Request;
use Redirect;

class DepartmentController extends Controller
{
public function index()
    {
        return view('departments.index')->with('data', Department::all());
    }

    public function create(GroupRequest $request)
    {
        $group = Department::create([
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

        return Redirect::route('tenant.departments.index')->with('status', 'group-created');
    }

    public function view(int $id)
    {
        return view('departments.view')->with('data', Department::findOrFail($id));
    }

    public function delete(int $id)
    {
        $group = Department::findOrFail($id);
        $group->members()->detach();
        $group->delete();

        return Redirect::route('tenant.departments.index')->with('status', 'group-deleted');
    }

    public function update(int $id, GroupRequest $request)
    {
        $group = Department::findOrFail($id);
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

        return Redirect::route('tenant.departments.view', $id)->with('status', 'group-updated');
    }

    public function removeFromGroup(int $groupId, int $memberId)
    {
        DB::table('department_user')->where('department_id', '=', $groupId)->where('user_id', '=', $memberId)->delete();

        return Redirect::route('tenant.departments.view', $groupId)->with('status', 'group-updated');
    }
}
