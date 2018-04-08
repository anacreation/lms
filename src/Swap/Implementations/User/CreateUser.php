<?php
/**
 * Author: Xavier Au
 * Date: 8/4/2018
 * Time: 2:30 PM
 */

namespace Anacreation\Lms\Swap\Implementations\User;


use Anacreation\Lms\Models\Role;
use Anacreation\Lms\Swap\Contracts\ICreateUser;
use App\User;

class CreateUser implements ICreateUser
{

    public function create(array $validatedData, string $password = null
    ): User {

        if (isset($validatedData['password'])) {
            $password = $validatedData['password'];
        }

        $newUser = new User();
        $newUser->name = $validatedData['name'];
        $newUser->email = $validatedData['email'];
        $newUser->password = bcrypt($password);
        $newUser->need_reset_password = $password !== null;
        if (isset($validatedData["supervisor_id"])) {
            $newUser->supervisor_id = $validatedData["supervisor_id"];
        }
        $newUser->save();

        foreach ($validatedData['role_ids'] as $roleId) {
            $newUser->assignRole(Role::findOrFail($roleId));
        }
        return $newUser;
    }
}