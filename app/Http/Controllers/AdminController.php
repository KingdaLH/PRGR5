<?php

namespace App\Http\Controllers;

// app/Http/Controllers/AdminController.php

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.index');
    }

    public function makeAdmin($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->isAdmin = 1;
            $user->save();
        }
        return redirect()->route('admin.index');
    }

    public function removeAdmin($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->isAdmin = 0;
            $user->save();
        }
        return redirect()->route('admin.index');
    }
}
