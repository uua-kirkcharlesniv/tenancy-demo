<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
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

    public function view()
    {

    }

    public function delete()
    {

    }

    public function edit()
    {
        
    }
}
