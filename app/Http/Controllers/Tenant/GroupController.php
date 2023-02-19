<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        return view('groups.index')->with('data', Group::all());
    }

    public function create()
    {

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
