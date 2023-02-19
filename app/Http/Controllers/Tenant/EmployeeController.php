<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;

class EmployeeController extends Controller
{
    public function edit()
    {
        return view('employees.edit');
    }

    public function create(CreateEmployeeRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('employee');

        // TODO: send invitation email

        return Redirect::route('tenant.employees.edit')->with('status', 'employee-added');
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return Redirect::route('tenant.employees.edit')->with('status', 'employee-deleted');
    }

    public function promote(int $id)
    {
        $user = User::findOrFail($id);
        $user->assignRole('manager');
        $user->removeRole('employee');

        return Redirect::route('tenant.employees.edit')->with('status', 'employee-promoted');
    }

    public function import()
    {
        dd('todo');
    }
}
