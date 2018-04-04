<?php

namespace Anacreation\Lms\Controllers;

use Anacreation\Lms\Events\UserCreated;
use Anacreation\Lms\Models\Role;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request) {

        $users = $user->paginate($request->get('paginate') ?? 30);

        return view("lms::admin.users.index", compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view("lms::admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $this->validate($request, [
            "email"         => "required|email|unique:users",
            "name"          => "required",
            "supervisor_id" => "nullable|in:" . implode(",",
                    User::pluck('id')->toArray()),
            "role_ids"      => "required",
            "role_ids.*"    => "in:" . implode(",",
                    Role::pluck('id')->toArray()),
        ]);

        $password = str_random(8);

        $newUser = new User();
        $newUser->name = $validatedData['name'];
        $newUser->email = $validatedData['email'];
        $newUser->password = bcrypt($password);
        $newUser->need_reset_password = true;
        if (isset($validatedData["supervisor_id"])) {
            $newUser->supervisor_id = $validatedData["supervisor_id"];
        }
        $newUser->save();

        foreach ($validatedData['role_ids'] as $roleId) {
            $newUser->assignRole(Role::findOrFail($roleId));
        }

        event(new UserCreated($newUser, $password));

        return redirect()->route("users.index")
                         ->withStatus("{$newUser->name} has just been added");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $user->load('roles');
        $user->load('supervisor');

        return view('lms::admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        $validatedData = $this->validate($request, [
            "email"         => "required|email|unique:users,email," . $user->id,
            "name"          => "required",
            "supervisor_id" => "nullable|in:" . implode(",",
                    User::pluck('id')->toArray()),
            "role_ids"      => "required",
            "role_ids.*"    => "in:" . implode(",",
                    Role::pluck('id')->toArray()),
        ], [
            "role_ids.required" => "Have to pick at least one role!",
            "role_ids.*.in"     => "We don't recognise the role you pick!",
            "supervisor_id.in"  => "We don't recognise the supervisor you pick!",
        ]);
        $validatedData = isset($validatedData['supervisor_id']) ? $validatedData : array_merge($validatedData,
            ['supervisor_id' => 0]);

        $user->update($validatedData);
        $user->syncRoles($validatedData['role_ids']);

        return redirect()->route("users.index")
                         ->withStatus("{$user->name} has just been added");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return void
     */
    public function destroy(User $user) {
        //
    }

    public function getUpdatePassword(Request $request) {
        $user = $request->user();

        return view("lms::auth.passwords.updatePassword", compact("user"));
    }

    public function updatePassword(Request $request) {
        $validatedData = $this->validate($request, [
            'password' => "required|confirmed"
        ]);

        $user = $request->user();
        $user->password = bcrypt($validatedData['password']);
        if ($user->need_reset_password) {
            $user->need_reset_password = false;
        }
        $user->save();

        return redirect('/home');
    }
}
