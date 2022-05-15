<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
    public function login(Request $request){

        try{
            $request->validate([
                'email' => ['required', 'string', 'email'],
                // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'password' => ['required'],
            ]);
        }
        catch(ValidationException $exc){
            Log::info("Validation Exception");
            return response()->json([
                'message' => $exc->getMessage(),
                'success' => 'failed'
            ]);
        }


        if(!Auth::attempt(request()->only('email', 'password'))) {
            return response()->json([
                'message' =>'login failed, confirm id and pwd',
                'success' => 'failed'
            ]);
        }

        $user = User::where('email', '=', $request->email)->first();

        return response()->json([
            'access_token' => $user->createToken('api-token')->plainTextToken,
            'type' => 'bearer',
            'success' => 'ok'
        ]);
    }

    public function register(Request $request){
        if(!Auth::attempt(request()->only('email', 'password'))) {
            return response()->json([
                'message' =>'login failed'
            ]);
        }

        $user = User::where('email', '=', $request->email)->first();

        return response()->json([
            'access_token' => $user->createToken('api-token')->plainTextToken,
            'type' => 'bearer',

            'message' => 'login success'
        ]);
    }
}
