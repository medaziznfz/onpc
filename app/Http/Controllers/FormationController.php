<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeFormation;
use Illuminate\Support\Facades\Auth;
use App\Models\Formation;
use App\Models\Governorate;
use App\Models\Delegation;
use App\Models\FormationAccepter;
use Illuminate\Support\Facades\DB;

class FormationController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Retrieve all demande_formation records for the authenticated user
        $demandes = DemandeFormation::where('id_user', $user->id)->get();

        return view('formations.formation', compact('demandes'));
    }

    public function details($id)
    {
        $demande = DemandeFormation::findOrFail($id);

        $gouvernorat = Governorate::find($demande->gouvernerat);
        $delegation = Delegation::find($demande->delegation);
        $formation = Formation::find($demande->formation_id);

        return view('formations.details', compact('demande', 'gouvernorat', 'delegation', 'formation'));
    }

    public function create()
    {
        // Get all governorates and formations from the database
        $governorates = Governorate::all();
        $formations = Formation::all();

        return view('formations.formation', compact('governorates', 'formations'));
    }

    public function store(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            // Redirect if the user is not authenticated
            return redirect()->route('login');
        }

        // Validate the incoming request
        $validated = $request->validate([
            'gouvernorat' => 'required|integer',
            'delegation' => 'required|integer',
            'formation_id' => 'required|integer',
        ]);

        // Create a new DemandeFormation record
        DemandeFormation::create([
            'id' => time(),
            'id_user' => $user->id,
            'gouvernerat' => $request->input('gouvernorat'),
            'delegation' => $request->input('delegation'),
            'formation_id' => $request->input('formation_id'),
            'status' => '1',
        ]);

        return redirect()->back()->with('success', 'Your formation request has been submitted.');
    }

    public function manageRequests(Formation $formation)
{
    // Get the authenticated user
    $user = auth()->user();

    // Debug: Check the user's gouver value
    \Log::info('User Gouver:', ['gouver' => $user->gouver]);

    // Get the gouver ID from the user
    $gouverId = $user->gouver;

    // Query demandes for the formation, filtered by gouvernerat if applicable
    $demandes = DemandeFormation::with(['gouvernorat', 'delegation', 'user'])
        ->where('formation_id', $formation->id)
        ->when($gouverId, function ($query, $gouverId) {
            return $query->where('gouvernerat', $gouverId);
        })
        ->latest()
        ->paginate(10);

    // Debug: Log the filtered demandes
    \Log::info('Filtered Demandes:', ['demandes' => $demandes]);

    return view('formations.requestdetails', [
        'formation' => $formation,
        'demandes' => $demandes,
    ]);
}

    public function showRequests()
{
    // Get the authenticated user
    $user = auth()->user();

    // Debug: Check the user's gouver value
    \Log::info('User Gouver:', ['gouver' => $user->gouver]);

    // Get the gouver ID from the user
    $gouverId = $user->gouver;

    // Query formations with demandes, filtered by gouvernerat if applicable
    $formations = Formation::with(['demandes' => function ($query) use ($gouverId) {
        if ($gouverId) {
            $query->where('gouvernerat', $gouverId);
        }
    }])->get();

    // Debug: Log the formations with their demandes
    \Log::info('Formations with Demandes:', ['formations' => $formations]);

    return view('formations.requestformation', compact('formations'));
}

    public function creationFormation(Request $request)
    {
        // Validate the request data
        $request->validate([
            'formation_id' => 'required|exists:formation,id',
            'date_prevue' => 'required|date',
            'demande_ids' => 'required|array',
        ]);

        // Insert into formation_accepter for each selected demande
        foreach ($request->demande_ids as $demandeId) {
            DB::table('formation_accepter')->insert([
                'formation_id' => $request->formation_id,
                'demande_id' => $demandeId,
                'date_prevue' => $request->date_prevue,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update the status of the demande to 2 (Accepted)
            $demande = DemandeFormation::findOrFail($demandeId);
            $demande->status = 2;
            $demande->save();
        }

        return redirect()->back()->with('success', 'Données ajoutées avec succès dans la formation.');
    }

    public function confirmeFormation(Request $request, Formation $formation)
    {
        // Validate the request data
        $request->validate([
            'processed_ids' => 'required|array',
            'processed_ids.*' => 'exists:demande_formation,id',
        ]);

        // Update the status of each selected demande to 4 (Confirmed)
        foreach ($request->processed_ids as $demandeId) {
            $demande = DemandeFormation::findOrFail($demandeId);
            $demande->status = 4;
            $demande->save();
        }

        return back()->with('success', 'تم تأكيد الطلبات المحددة بنجاح');
    }

    public function refuseFormation(Request $request, Formation $formation)
    {
        // Validate the request data
        $request->validate([
            'processed_ids' => 'required|array',
            'processed_ids.*' => 'exists:demande_formation,id',
        ]);

        // Update the status of each selected demande to 3 (Refused)
        foreach ($request->processed_ids as $demandeId) {
            $demande = DemandeFormation::findOrFail($demandeId);
            $demande->status = 3;
            $demande->save();
        }

        return back()->with('success', 'تم رفض الطلبات المحددة بنجاح');
    }
}