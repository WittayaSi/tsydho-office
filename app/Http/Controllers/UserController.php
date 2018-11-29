<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth') && $this->middleware('auth.admin');
    }

    public function index()
    {
        $users = User::all();
        return view('backend.setting.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        //dd(request()->all(), $user);
        $attribute = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'color_code' => 'required',
            'user_role' => ['required']
        ]);
        $user->update($attribute);

        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
