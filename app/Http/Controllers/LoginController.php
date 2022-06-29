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
            // TODO :: return normally with good code and good error
            return 'validation failed, user not exist';
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        // TODO :: good return some api token instead
        return $this->authenticated($request, $user);
    }
}