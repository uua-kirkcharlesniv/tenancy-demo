<?php

namespace Database\Factories\Tenant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
*/
class EmployeeFactory extends Factory
{
    protected $model = User::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'employee_id' => strtoupper(mb_substr(strval(tenant('company')), 0, 3)) . "$" . Str::random(5),
            // 'first_name' => fake()->firstName(),
            // 'last_name' => fake()->lastName(),
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
