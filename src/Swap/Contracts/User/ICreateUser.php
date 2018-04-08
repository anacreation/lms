<?php
/**
 * Author: Xavier Au
 * Date: 8/4/2018
 * Time: 2:28 PM
 */

namespace Anacreation\Lms\Swap\Contracts;


use App\User;

interface ICreateUser
{
    public function create(array $validatedData, string $password): User;
}