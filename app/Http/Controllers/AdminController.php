<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users_show()
    { 
        $currentUserName = Auth::user()->name;
        $users = User::where('name', '!=', $currentUserName)->get();
        return view('users_show', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.users_show')->with('success', 'Роль пользователя обновлена!');
    }
}
