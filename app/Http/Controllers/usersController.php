<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class usersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update($request->all());
        
        return redirect()->back()->with('success', 'Perfil actualizado exitosamente');
    }
}
