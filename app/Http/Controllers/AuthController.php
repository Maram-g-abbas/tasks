<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use APIResponse;

    /*
    regestring new user to database
    check for unique email
    assign default user role untile updated by the admen
    */
    public function regester(Request $request){
        //validating user input
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        // save user to data base
        $user = User::create($fields);

        //assign user role
        $user->assignRole('user'); 

        //issue token for the user
        $token = $user->createToken($request->name);

        return $this->successResponse([
            'user' => $user,
            'token' =>$token->plainTextToken
        ]);
    }

    public function login(Request $request){

        //validating user input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /* check for the user exist by email 
        the email is the unique value in the user table
        */
        $user = User::where('email',$request->email)->first();

        // authenticate user using hashed password
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        //issue token for the user
        $token = $user->createToken($user->name);
        return $this->successResponse([
            'user' => $user,
            'token' =>$token->plainTextToken
        ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return $this->successResponse("logout success");
    }

    public function profile(Request $request){
            return $request->user();
    }
}
