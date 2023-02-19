<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTenantRequest;
use Illuminate\Support\Facades\Storage;
use Redirect;

class CompanyController extends Controller
{
    public function edit()
    {
        return view('company.edit');
    }

    public function updateCompany(UpdateTenantRequest $request)
    {
        if($request->validated('logo') != null) {
            $oldLogo = tenant()->logo;

            $filename = Storage::disk('public')->put('logo', $request->validated('logo'));
            tenant()->update([
                'logo' => $filename
            ]);

            if($oldLogo != null) {
                Storage::disk('public')->delete($oldLogo);
            }
        }

        tenant()->update([
            'company' => $request->validated('company'),
        ]);

        return Redirect::route('tenant.company.edit')->with('status', 'profile-updated');
    }
}
