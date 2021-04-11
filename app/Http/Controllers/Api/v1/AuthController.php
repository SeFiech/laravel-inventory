<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

use App\User;


class AuthController extends ApiBaseController
{

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return $this->sendRespose(['errors' => $validator->errors()->all()], 422);
            }

            $user = User::where('email', $request->email)->first();

            if ($user) {
                if (Hash::check($request->password, $user->password)) { // check password
                    if ($user->isActive == 1) { // is user active
                        if ($user->ApiActive == 1) { // is user api active
                            $token = $user->createToken('auth_token')->accessToken;
                            $response = ['token' => $token];
                            return $this->sendRespose($response, 200);
                        } else {
                            $response = ["message" => "User API is not active"];
                            return $this->sendRespose($response, 422);
                        }
                    } else {
                        $response = ["message" => "User is not active"];
                        return $this->sendRespose($response, 422);
                    }
                } else {
                    $response = ["message" => "Password mismatch"];
                    return $this->sendRespose($response, 422);
                }
            } else {
                $response = ["message" => 'User does not exist'];
                return $this->sendRespose($response, 422);
            }
        } catch (\Exception $e) {
            return $this->sendCatchError($e);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        var_dump($request['remember_token']);
        $request['isActive'] = 1;
        $request['ApiActive'] = 1;
        var_dump($request->toArray());
        $user = User::create($request->toArray());
        $token = $user->createToken('auth_token')->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }
}








  // public function login(Request $request)
    // {
    //     try {

    //         $request->validate([
    //             'email' => 'email|required',
    //             'password' => 'required'
    //         ]);

    //         $credentials = request(['email', 'password']);


    //         //if (User::where('email', '=',  $credentials['email'])->exists()) {
    //             if (Auth::attempt($credentials)) {
    //                 $user = User::where('email', $credentials['email'])->first();


    //                 if (Auth::user()->isActive == true) {
    //                     if (Auth::user()->ApiActive == true) {
    //                         $userdata['user']['token'] = $user->createToken('auth-token')->accessToken;
    //                         $userdata['user']['id'] = $user->id;
    //                         $userdata['user']['name'] = $user->name;
    //                         $userdata['user']['email'] = $user->email;

    //                         //return $this->http_codes['202'];
    //                         return $this->sendSuccessData($userdata);
    //                     } else {
    //                         return $this->sendFailMessage('User has no API Access');
    //                     }
    //                 } else {
    //                     return $this->sendFailMessage('User is not active');
    //                 }
    //             } else {
    //                 return $this->sendFailMessage('Login failed');
    //             }
    //         // } else {
    //         //     return $this->sendFailMessage('User not found');
    //         // }
    //     } catch (\Exception $e) {
    //         return $this->sendError($e);
    //     }
    // }
