<?php
/**
 * Author: Xavier Au
 * Date: 8/4/2018
 * Time: 2:37 PM
 */

namespace Anacreation\Lms\Swap\Contracts\User;


interface IStoreUserRequest
{

    public function validated();

    public function rules();

    public function authorize();
}