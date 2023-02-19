<?php

namespace Database\Seeders;

use App\Models\Tenant\Employee;
use Database\Factories\Tenant\EmployeeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding... ' . tenant('company'));

        Log::debug(tenant());

        $employees = EmployeeFactory::new()->count(10)->create();
    }
}
