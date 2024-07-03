<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|string|in:admin,doctor,police',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::create([
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);
        return $this->apiResponse($user,'User successfully registered',201);
    }
}
