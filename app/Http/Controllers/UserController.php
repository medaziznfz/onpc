<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Certificat;
use App\Models\Governorate;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function show($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Pass the user data to the view
        return view('users.details', compact('user'));
    }

    public function index()
{
    // Start the query for all users
    $query = User::query();

    // Join the Governorate table to get the governorate name
    $query->leftJoin('governorates', 'users.gouver', '=', 'governorates.id')
          ->select('users.*', 'governorates.name as governorate_name'); // Select the governorate name

    // Get all users
    $users = $query->get();

    // Fetch all governorates for the dropdown
    $governorates = Governorate::all();

    // Pass the results to the view
    return view('management/users', compact('users', 'governorates'));
}
    
    
    public function updateUser(Request $request)
    {
        $user = User::find($request->id);
    
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gouver = $request->gouver;
            $user->role = $request->role;
            $user->save();
    
            return response()->json([
                'success' => true,
                'user' => $user // Return the updated user data
            ]);
        }
    
        return response()->json(['success' => false]);
    }
}
