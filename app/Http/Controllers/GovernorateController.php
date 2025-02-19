<?php

namespace App\Http\Controllers;

use App\Models\Delegation; // Import the Delegation model
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function getDelegations(Request $request)
    {
        $governorate_id = $request->query('governorate_id'); 
        $delegations = Delegation::where('id_gouver', $governorate_id)->get();
        return response()->json($delegations);
    }
}
