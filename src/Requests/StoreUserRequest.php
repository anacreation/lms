<?php

namespace Anacreation\Lms\Requests;

use Anacreation\Lms\Models\Role;
use Anacreation\Lms\Swap\Contracts\User\IStoreUserRequest;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest implements IStoreUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        return [
            "email"         => "required|email|unique:users",
            "name"          => "required",
            "supervisor_id" => "nullable|in:" . implode(",",
                    User::pluck('id')->toArray()),
            "role_ids"      => "required",
            "role_ids.*"    => "in:" . implode(",",
                    Role::pluck('id')->toArray()),
        ];
    }
}
