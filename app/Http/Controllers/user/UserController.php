<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    //this handles users

    public function index()
    {
        return User::all();
    }

}
