<?php

use Anacreation\Lms\Models\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    private $users = [
        [
            'name'     => 'Xavier Au',
            'email'    => 'xavier.au@gmail.com',
            'password' => '123456',
            'roles'    => ['super_admin', 'admin', 'learner', 'instructor']
        ],
        [
            'name'       => 'Carson Wong',
            'email'      => 'carson.wong@gmail.com',
            'password'   => '123456',
            'roles'      => ['learner'],
            'supervisor' => "xavier.au@gmail.com",
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        array_walk($this->users, function ($userData) {
            if (!$user = User::whereEmail(['email' => $userData['email']])
                             ->first()) {
                $this->createUser($userData);
            }
        });
    }

    private function createUser(array $userData) {
        $user = new User();
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = bcrypt($userData['password']);
        $user->save();

        if (isset($userData['roles'])) {
            $this->assignRoles($user, $userData['roles']);
        }
        if (isset($userData['supervisor'])) {
            $this->assignSupervisor($user, $userData['supervisor']);
        }
    }

    private function assignRoles(User $user, array $roleCodes) {
        foreach ($roleCodes as $code) {
            if ($role = Role::whereCode($code)->first()) {
                $user->roles()->save($role);
            }
        }
    }

    private function assignSupervisor(User $user, string $supervisorEmail) {
        if ($supervisor = User::whereEmail($supervisorEmail)->first()) {
            $user->supervisor()->associate($supervisor);
            $user->save();
        }
    }
}
