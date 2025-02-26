<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeFormation;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use App\Models\Governorate;
use App\Models\Delegation;


class FormationController extends Controller
{
    public function index()
    {
        // For demonstration, we're using a fixed user id = 5.
        // In a real application you might use: $userId = auth()->id();
        $userId = auth()->id();
    
        // Retrieve all demande_formation records for user 5.
        $demandes = \App\Models\DemandeFormation::where('id_user', $userId)->get();
    
        return view('formations.formation', compact('demandes'));
    }

    public function details($id)
    {
        $demande = DemandeFormation::findOrFail($id);

        $gouvernorat = Governorate::find($demande->gouvernerat);
        $delegation   = Delegation::find($demande->delegation);
        $formation    = Formation::find($demande->formation_id);

        // You can format your details as needed.
        return view('formations.details', compact('demande', 'gouvernorat', 'delegation', 'formation'));
    }
    
    public function create()
    {
        // Get all governorates and formations from the database
        $governorates = Governorate::all();
        $formations   = Formation::all();

        return view('formations.formation', compact('governorates', 'formations'));
    }

    public function store(Request $request)
    {
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = Auth::id();
        if (!$user_id) {
            // Rediriger si l'utilisateur n'est pas connecté
            return redirect()->route('login');
        }

        // Validate the incoming request
        $validated = $request->validate([
            'gouvernorat' => 'required|integer',
            'delegation' => 'required|integer',
            'formation_id'=> 'required|integer',
        ]);
       

        DemandeFormation::create([
            'id' => time(),
            'id_user' => $user_id,
            'gouvernerat' => $request->input('gouvernorat'),
            'delegation' => $request->input('delegation'),
            'formation_id'=> $request->input('formation_id'),
            'status' => '1',
       ]);

        return redirect()->back()->with('success', 'Your formation request has been submitted.');
    }

    public function manageRequests(Formation $formation)
    {
        $demandes = DemandeFormation::with(['gouvernorat', 'delegation', 'user'])
            ->where('formation_id', $formation->id)
            ->latest()
            ->paginate(10);

        return view('formations.requestdetails', [
            'formation' => $formation,
            'demandes' => $demandes
        ]);
    }



    public function showRequests()
    {
        $formations = Formation::withCount('demandes')->get();
        return view('formations.requestformation', compact('formations'));
    }
}






