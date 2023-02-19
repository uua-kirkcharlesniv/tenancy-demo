<?php

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateTenantRoles implements ShouldQueue
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
        $this->tenant->run(function ($tenant) {
            $owner = Role::create([
                'name' => 'owner',
            ]);
            $manager = Role::create([
                'name' => 'manager',
            ]);
            $employee = Role::create([
                'name' => 'employee',
            ]);
            $manageCompany = Permission::create([
                'name' => 'manage-company',
            ]);
            $manageEmployeesPermission = Permission::create([
                'name' => 'manage-employees',
            ]);
            $manageGroupsPermission = Permission::create([
                'name' => 'manage-groups',
            ]);
            $manageDepartmentsPermission = Permission::create([
                'name' => 'manage-departments',
            ]);
            $basicPermission = Permission::create([
                'name' => 'employee-basic',
            ]);

            $owner->syncPermissions([$manageCompany, $manageEmployeesPermission, $manageGroupsPermission, $manageDepartmentsPermission, $basicPermission]);
            $manager->syncPermissions([$manageEmployeesPermission, $manageGroupsPermission, $manageDepartmentsPermission, $basicPermission]);
            $employee->syncPermissions([$basicPermission]);
        });
    }
}
