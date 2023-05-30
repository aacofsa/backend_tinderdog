<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function me(Request $req)
    {
        $token = $req->bearerToken();
        if(!$token){
            return response()->json([
                "message" => "Unauthorized"
            ],403);
        }
        return $req->user();
    }
}
