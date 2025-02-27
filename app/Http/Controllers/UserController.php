<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Certificat;
use App\Models\Governorate;
use App\Models\Grade; // Make sure Grade model is imported
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Show details for a specific user
    public function show($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);
        return view('users.details', compact('user'));
    }

    // List users for management
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch users along with their associated grade and governorate.
        // Optionally filter by governorate if the authenticated user has one.
        $users = User::with(['grade', 'governorate'])
            ->when($user->gouver, function ($query) use ($user) {
                $query->where('gouver', $user->gouver);
            })
            ->get();

        // Fetch all governorates and grades for the modal dropdowns.
        $governorates = Governorate::all();
        $grades = Grade::all();

        return view('management.users', compact('users', 'governorates', 'grades'));
    }

    // Update a user based on submitted form data
    public function updateUser(Request $request)
    {
        $user = User::find($request->id);

        if ($user) {
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->role  = $request->role;

            // For role 1 (جهوي): save both governorate and grade
            // For role 2 (مركزي): save only grade (and reset governorate)
            if ($request->role == 1) {
                $user->gouver   = $request->gouver;
                $user->grade_id = $request->grade;
            } elseif ($request->role == 2) {
                $user->grade_id = $request->grade;
                $user->gouver   = null;
            } else {
                $user->gouver   = null;
                $user->grade_id = null;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'user'    => $user // Return the updated user data
            ]);
        }

        return response()->json(['success' => false]);
    }
}
