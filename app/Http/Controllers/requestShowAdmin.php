<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificat;


use App\Helpers\NotificationHelper;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class requestShowAdmin extends Controller
{
    //
    public function index()
    {
            // Get the authenticated user
            $user = Auth::user();
        
            // Start the query for Certificat and join the related tables
            $query = Certificat::query()
                ->leftJoin('governorates', 'certificats.gouvernorat', '=', 'governorates.id')
                ->leftJoin('delegations', 'certificats.delegation', '=', 'delegations.id')
                ->select('certificats.*', 'governorates.name as gouvernorat_name', 'delegations.name as delegation_name');
        
            // Filter by gouvernorat if the user's gouver is not null
            if ($user->gouver) {
                $query->where('governorates.id', $user->gouver);
            }
        
            // Get the filtered results
            $requests = $query->get();
            
            return view('prevention.request', compact('requests'));
       
    }


}
