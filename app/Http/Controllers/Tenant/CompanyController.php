<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTenantRequest;
use Auth;
use Config;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Illuminate\Http\Request;

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

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();
        $tenant = tenant();

        Auth::logout();

        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $tenant->delete();

        return Redirect::to(Config::get('app.url').'/');
    }
}
