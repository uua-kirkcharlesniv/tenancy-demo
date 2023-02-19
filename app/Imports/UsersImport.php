<?php

namespace App\Imports;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithValidation, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $isManager = $row['manager'];
        
        if(Auth::user()->can('manage-company')) {
            $isManager = strtoupper(trim($isManager)) == "Y";
        } else {
            $isManager = false;
        }

        $user = new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
        ]);


        if($isManager) {
            $user->assignRole('manager');
        } else {
            $user->assignRole('employee');
        }

        return $user;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => [
                'required', 'max:255', Password::defaults(),
            ],
        ];
    }
}
