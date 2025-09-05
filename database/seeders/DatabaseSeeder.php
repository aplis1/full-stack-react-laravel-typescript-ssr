<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    $userRole = Role::create(['name' => RolesEnum::User->value]);
    $this->command->info('User role created: ' . $userRole->name);
    $commenterRole = Role::create(['name' => RolesEnum::Commenter->value]);
    $this->command->info('Commenter role created: ' . $commenterRole->name);
    $adminRole = Role::create(['name' => RolesEnum::Admin->value]);
    $this->command->info('Admin role created: ' . $adminRole->name);


    $manageFeaturesPermission = Permission::create([
     'name' => PermissionsEnum::ManageFeatures->value
     ]);
    $this->command->info('Permission created: ' . $manageFeaturesPermission->name);



    $manageUsersPermission = Permission::create([
     'name' => PermissionsEnum::ManageUsers->value
     ]);
    $this->command->info('Permission created: ' . $manageUsersPermission->name);



    $manageCommentsPermission = Permission::create([
     'name' => PermissionsEnum::ManageComments->value
     ]);
    $this->command->info('Permission created: ' . $manageCommentsPermission->name);


        $upvoteDownvotePermission = Permission::create([
            'name' => PermissionsEnum::UpvoteDownvote->value
        ]);
        $this->command->info('Permission created: ' . $upvoteDownvotePermission->name);


        $userRole->syncPermissions([$upvoteDownvotePermission]);
        $this->command->info('User role permissions synced.');
        $commenterRole->syncPermissions([$manageCommentsPermission, $upvoteDownvotePermission]);
        $this->command->info('Commenter role permissions synced.');
        $adminRole->syncPermissions([
            $manageFeaturesPermission, 
            $manageUsersPermission, 
            $manageCommentsPermission, 
            $upvoteDownvotePermission
        ]);
        $this->command->info('Admin role permissions synced.');

        $user = User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ]);
        $user->assignRole(RolesEnum::User->value);
        $this->command->info('User created: ' . $user->email);

        $commenter = User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ]);
        $commenter->assignRole(RolesEnum::Commenter->value);
        $this->command->info('Commenter created: ' . $commenter->email);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole(RolesEnum::Admin->value);
        $this->command->info('Admin created: ' . $admin->email);
    }
}
