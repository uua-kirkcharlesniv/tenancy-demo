<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function edit()
    {
        return view('company.edit');
    }
}
