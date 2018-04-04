<?php

namespace Anacreation\Lms\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function getMyInfo(): View {

        return view('lms::frontend.users.my_info');
    }

    public function updateMyInfo(Request $request) {
        $user = $request->user();
        $validatedData = $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed'
        ]);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($password = $validatedData["password"] ?? null) {
            $user->password = bcrypt($password);
        }
        $user->save();

        return redirect()->route('home')->withStatus("My Info updated!");

    }
}
