<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return response()->view('incorrect login', [], 401);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);
        return json_encode(['token' => Auth::user()->api_token, 'user_id' => Auth::user()->id]);
    }
}
