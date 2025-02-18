<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
        {
            $users = User::all(); // Make sure to import User model
            return view('users.index', compact('users'));
        }
}
