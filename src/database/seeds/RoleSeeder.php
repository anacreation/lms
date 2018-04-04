<?php

use Anacreation\Lms\Models\Permission;
use Anacreation\Lms\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    private $roles = [
        [
            'label'       => 'Super Admin',
            'code'        => 'super_admin',
            'permissions' => [
                'index_user',
                'show_user',
                'store_user',
                'edit_user',
                'update_user',
                'delete_user',
            ]
        ],
        [
            'label'       => 'Admin',
            'code'        => 'admin',
            'permissions' => [
                'index_curriculum',
                'show_curriculum',
                'store_curriculum',
                'edit_curriculum',
                'update_curriculum',
                'delete_curriculum',
            ]
        ],
        [
            'label'       => 'Course Instructor',
            'code'        => 'instructor',
            'permissions' => [
                'index_lesson',
                'show_lesson',
                'store_lesson',
                'edit_lesson',
                'update_lesson',
                'delete_lesson',
                'index_test',
                'show_test',
                'store_test',
                'edit_test',
                'update_test',
                'delete_test',
            ]
        ],
        [
            'label' => 'Learner',
            'code'  => 'learner',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $createRole = function (array $data) {

            $new_role = Role::firstOrCreate(['code' => $data['code']],
                ['label' => $data['label']]);
            if (isset($data['permissions'])) {
                foreach ($data['permissions'] as $permissionCode) {
                    if ($permission = Permission::whereCode($permissionCode)
                                                ->first()) {
                        $new_role->permissions()->save($permission);
                    }

                }
            }
        };


        array_walk($this->roles, $createRole);

    }
}
