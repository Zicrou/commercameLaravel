<?php

namespace App\Http\Controllers\V1;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Faker\Provider\ar_EG\Person;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:users',
            'password' => 'required',
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);
        return [
            'user' => $user, 
            'token' => $token->plainTextToken];
    }

    public function login(Request $request){
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return ['message' => 'The provided credentials are incorrect.'];
        }
    
        $token = $user->createToken($user->name);
        $tokenFromRequest = PersonalAccessToken::findToken($token->plainTextToken);
        //$tokenFromRequest->user;
        return [
            'user' => $user, 
            'token' => $token->plainTextToken,
            '$tokenFromRequest' => $tokenFromRequest->tokenable_id,
        ];
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
         return ['message' => 'you are logged out'];
    }
}
