<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Shows the login form
    public function login(){
        return view('auth.loginForm');
    }

    // Check the credentials and regenerate a session where the user is logged
    public function applyLogin(Request $request){

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $login = $validated['email'];

        // Query the database to get either the usename that the user typed, the email or both.
        $user = User::where('email', $login)
            ->orWhere('username', $login)->first();

        // No user was found
        if(!$user){
            return redirect()->back()->withErrors(['email' => 'Email incorrecte']);
        }

        // Attempt login with the email, then with the username
        if(Auth::attempt(['email' => $user->email, 
                'password' => $request->input('password')]) ||
            Auth::attempt(['username' => $user->username, 
                    'password' => $request->input('password')]))
        {
            // Log the user in. Regenerated automatically the session
            Auth::loginUsingId($user->id);
            return redirect('/');
        }else{
            return redirect()->back()->withErrors(['email' => 'Authentifiants incorrect']);
        }
    }

    // Log out the user by regenerating a session
    public function logout(){
        Auth::logout();

        session()->invalidate();
        session()->regenerate();

        return redirect('/');
    }
}
