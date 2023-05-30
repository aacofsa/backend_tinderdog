<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $req){
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'token' =>  $user->createToken("accessToken")->plainTextToken,
        ]);
        
    }

    public function login(Request $req){
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $req->email)->first();

        if (! $user || ! Hash::check($req->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
     
        $user->tokens()->delete();
        return response()->json($user->createToken("accessToken"));
    }
}
