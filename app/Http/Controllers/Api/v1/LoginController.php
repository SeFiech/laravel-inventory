<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\v1\ApiBaseController as ApiBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;


class LoginController extends ApiBaseController
{

    public function index(Request $request)
    {
        $this->sendSuccessData($request);
    }

    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);



            if (User::where('email', '=', $request->email)->exists()) {
                if (Auth::attempt($credentials)) {
                    $user = User::where('email', $request->email)->first();


                    if (Auth::user()->isActive == true) {
                        if (Auth::user()->ApiActive == true) {
                            $userdata['user']['token'] = $user->createToken('auth-token')->accessToken;
                            $userdata['user']['id'] = $user->id;
                            $userdata['user']['name'] = $user->name;
                            $userdata['user']['email'] = $user->email;

                            return $this->sendSuccessData($userdata);
                        } else {
                            return $this->sendFailMessage('User has no API Access');
                        }
                    } else {
                        return $this->sendFailMessage('User is not active');
                    }
                } else {
                    return $this->sendFailMessage('Login failed');
                }
            } else {
                return $this->sendFailMessage('User not found');
            }
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
