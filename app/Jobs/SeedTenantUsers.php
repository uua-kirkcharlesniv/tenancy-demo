<?php

namespace App\Jobs;

use App;
use App\Models\Tenant;
use App\Models\User;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SeedTenantUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Tenant $tenant)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (App::environment(['local', 'staging'])) {
            $this->tenant->run(function ($tenant) {
                $manager = User::create([
                    'name' => 'Manager Test',
                    'email' => 'manager@example.com',
                    'password' => Hash::make('password'),
                ]);
                $employee = User::create([
                    'name' => 'Employee Test',
                    'email' => 'employee@example.com',
                    'password' => Hash::make('password'),
                ]);

                $manager->assignRole('manager');
                $employee->assignRole('employee');
            });
        }
    }
}
