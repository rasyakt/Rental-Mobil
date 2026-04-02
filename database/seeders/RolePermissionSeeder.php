<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Full access to all system features',
        ]);

        $staffRole = Role::create([
            'name' => 'staff',
            'display_name' => 'Staff',
            'description' => 'Can manage bookings, vehicles, and drivers',
        ]);

        $customerRole = Role::create([
            'name' => 'customer',
            'display_name' => 'Customer',
            'description' => 'Can make bookings and view their history',
        ]);

        // Create Permissions
        $permissions = [
            // Dashboard
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard'],
            ['name' => 'view_admin_dashboard', 'display_name' => 'View Admin Dashboard'],

            // Branch Management
            ['name' => 'view_branches', 'display_name' => 'View Branches'],
            ['name' => 'create_branch', 'display_name' => 'Create Branch'],
            ['name' => 'edit_branch', 'display_name' => 'Edit Branch'],
            ['name' => 'delete_branch', 'display_name' => 'Delete Branch'],

            // Vehicle Management
            ['name' => 'view_vehicles', 'display_name' => 'View Vehicles'],
            ['name' => 'create_vehicle', 'display_name' => 'Create Vehicle'],
            ['name' => 'edit_vehicle', 'display_name' => 'Edit Vehicle'],
            ['name' => 'delete_vehicle', 'display_name' => 'Delete Vehicle'],

            // Driver Management
            ['name' => 'view_drivers', 'display_name' => 'View Drivers'],
            ['name' => 'create_driver', 'display_name' => 'Create Driver'],
            ['name' => 'edit_driver', 'display_name' => 'Edit Driver'],
            ['name' => 'delete_driver', 'display_name' => 'Delete Driver'],

            // Booking Management
            ['name' => 'view_bookings', 'display_name' => 'View Bookings'],
            ['name' => 'create_booking', 'display_name' => 'Create Booking'],
            ['name' => 'edit_booking', 'display_name' => 'Edit Booking'],
            ['name' => 'confirm_booking', 'display_name' => 'Confirm Booking'],
            ['name' => 'cancel_booking', 'display_name' => 'Cancel Booking'],

            // Payment Management
            ['name' => 'view_payments', 'display_name' => 'View Payments'],
            ['name' => 'process_payment', 'display_name' => 'Process Payment'],
            ['name' => 'refund_payment', 'display_name' => 'Refund Payment'],

            // User Management
            ['name' => 'view_users', 'display_name' => 'View Users'],
            ['name' => 'create_user', 'display_name' => 'Create User'],
            ['name' => 'edit_user', 'display_name' => 'Edit User'],
            ['name' => 'delete_user', 'display_name' => 'Delete User'],

            // Reports
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
            ['name' => 'export_reports', 'display_name' => 'Export Reports'],

            // Tracking
            ['name' => 'view_tracking', 'display_name' => 'View Tracking'],

            // Maintenance
            ['name' => 'view_maintenance', 'display_name' => 'View Maintenance'],
            ['name' => 'create_maintenance', 'display_name' => 'Create Maintenance'],
            ['name' => 'edit_maintenance', 'display_name' => 'Edit Maintenance'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions to roles
        $adminPermissions = Permission::all();
        $adminRole->permissions()->attach($adminPermissions);

        $staffPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_branches',
            'view_vehicles',
            'view_drivers',
            'view_bookings',
            'create_booking',
            'edit_booking',
            'view_payments',
            'view_tracking',
            'view_maintenance',
            'create_maintenance',
            'edit_maintenance',
        ])->get();
        $staffRole->permissions()->attach($staffPermissions);

        $customerPermissions = Permission::whereIn('name', [
            'view_dashboard',
            'view_vehicles',
            'create_booking',
            'view_bookings',
            'view_payments',
        ])->get();
        $customerRole->permissions()->attach($customerPermissions);
    }
}
