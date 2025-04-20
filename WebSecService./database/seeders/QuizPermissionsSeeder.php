<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QuizPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create quiz permissions
        $permissions = [
            'create_quiz',
            'edit_quiz',
            'delete_quiz',
            'take_quiz',
            'view_submissions',
            'grade_submissions',
            'view_own_grades'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Get roles
        $instructorRole = Role::where('name', 'Instructor')->first();
        $studentRole = Role::where('name', 'Student')->first();

        if ($instructorRole) {
            $instructorRole->givePermissionTo([
                'create_quiz',
                'edit_quiz',
                'delete_quiz',
                'view_submissions',
                'grade_submissions'
            ]);
        }

        if ($studentRole) {
            $studentRole->givePermissionTo([
                'take_quiz',
                'view_own_grades'
            ]);
        }
    }
}
