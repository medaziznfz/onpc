<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificat;
use App\Models\SpecificActivity;
use App\Models\SpecificActivityErp;
use App\Models\Document;
use App\Models\Visite;
use Illuminate\Support\Facades\Hash;
use App\Models\Delegation; // Import the Delegation model
use App\Models\Governorate; // Import the Delegation model
use App\Models\TypeActivite; // Import the Delegation model


use Mpdf\Mpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CertificatController extends Controller
{

    public function index()
    {
        // Récupérer tous les certificats de l'utilisateur connecté
        $certificats = Certificat::where('user_id', auth()->id())
                        ->with('documents')
                        ->orderByDesc('created_at')
                        ->get();
    
        return view('prev', [
            'certificats' => $certificats,
        ]);
    }

    public function getDetails($id)
    {
        $certificat = Certificat::where('user_id', auth()->id())
                    ->with('documents')
                    ->findOrFail($id);
    
        return view('partials.details_certif', compact('certificat'))->render();
    }


    public function createNewCertificat(Request $request)
    {
        // Créer un nouveau certificat avec statut initial
        $newCertificat = Certificat::create([
            'user_id' => auth()->id(),
            'statut' => 1, // Statut initial pour démarrer les étapes
            // Ajoutez ici les autres champs nécessaires
        ]);

        // Réinitialiser la session
        session()->forget('new_certificat_request');

        // Rediriger vers la page principale
        return redirect()->route('prev')->with('success', 'تم تأكيد المرحلة بنجاح!');
    }

    public function validateStep($id)
        {
            $certificat = Certificat::findOrFail($id);
            $certificat->statut = 4;
            $certificat->verified_at = now(); // Met à jour la date de vérification
            $certificat->expiry_at = now()->addYears(2); // Définit l'expiration à 2 ans plus tard

            // Générer le hash basé sur id, user_id et gouvernorat
            $hashString = $certificat->id . $certificat->user_id . $certificat->gouvernorat;
            $certificat->hash = hash('sha256', $hashString); // Générer un hash SHA-256

            $certificat->save();

            // Mettre à jour la dernière visite
            $lastVisite = Visite::where('certificat_id', $certificat->id)
                ->latest()
                ->first();

            if ($lastVisite) {
                $lastVisite->status = 1;
                $lastVisite->save();
            }

            notify($certificat->user_id, 'الشهادة جاهزة', 'لقد تم قبول مطلبك الآن يمكنك الحصول عليها بالإدارة الجهوية', '/prev');
            
            return redirect()->back()->with('success', 'تم تأكيد المرحلة بنجاح!');
        }   

    public function updateLastVisiteStatus($certificatId)
    {
        $lastVisite = Visite::where('certificat_id', $certificatId)
            ->latest()
            ->first();

        if($lastVisite) {
            $lastVisite->status = 2;
            $lastVisite->save();
            return redirect()->back()->with('success', 'تم تأكيد المرحلة بنجاح!');
        }

        return response()->json(['success' => false], 404);
    }

    public function validateDocuments($id)
    {
        // Trouver le certificat par son ID
        $certificat = Certificat::findOrFail($id);

        // Mettre à jour le statut à 3 (validation des documents)
        $certificat->statut = 3;
        $certificat->save();

        // Retourner une réponse JSON pour une mise à jour dynamique
        return redirect()->back()->with('success', 'تم إرسال الطلب بنجاح!');
    }

    public function show($id)
    {
        $certificat = Certificat::findOrFail($id);
        return view('certificat.show', compact('certificat'));
    }

    public function showCertificat($certificatId)
    {
        $certificat = Certificat::findOrFail($certificatId);
        $selectedDocuments = $certificat->documents; // Documents sélectionnés
        return view('user.certificats.show', compact('certificat', 'selectedDocuments'));
    }

    public function showVisite($id)
    {
        $certificat = Certificat::with('visites')->findOrFail($id);
        return view('prev', compact('certificat'));
    }

    public function storeVisite(Request $request)
    {
        $data = $request->validate([
            'certificat_id' => 'required|exists:certificats,id',
            'user_id' => 'required|exists:certificats,user_id',
            'date_visite'   => 'required|date',
            'heure_visite'  => 'required',
            'status'        => 'required|in:0,1,2',
            'remarque'      => 'nullable|string',
        ]);

        \App\Models\Visite::create($data);
        notify($request->user_id, 'برمجة زيارة', 'الرجاء التحقق من مطلبك', '/prev');
        return redirect()->back()->with('success', 'La visite a été ajoutée avec succès.');
    }

    


    // Afficher le formulaire de sélection des documents
    public function showDocumentSelection(Certificat $certificat)
    {
        // Récupérer tous les documents disponibles
        $documents = Document::all();

        // Récupérer les IDs des documents déjà sélectionnés
        $selectedDocumentIds = $certificat->documents->pluck('id')->toArray();

        return view('prev', compact('certificat', 'documents', 'selectedDocumentIds'));
    }

    // Enregistrer les documents sélectionnés
    public function storeDocuments(Request $request, Certificat $certificat)
    {
        // Validation des données
        $request->validate([
            'selected_documents' => 'sometimes|array',
            'selected_documents.*' => 'integer|exists:documents,id',
        ]);

        // Synchroniser les documents sélectionnés avec la table pivot
        $certificat->documents()->sync($request->selected_documents ?? []);

        $certificat->statut = 2;
        $certificat->save();
        notify($certificat->user_id, 'الوثائق المطلوبة', 'الرجاء التحقق من مطلبك', '/prev');
        return redirect()->back()->with('success', 'تم حفظ المستندات بنجاح');
    }

    public function showDetails($id)
    {
        $certificat = Certificat::findOrFail($id);
    
        return view('prevention.details', compact('certificat'))->render();
    }
    


    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'gouvernorat' => 'required|integer',
            'delegation' => 'required|integer',
            'type-activite' => 'required|integer',
            'specific-activity' => 'nullable|string', 
            'specific-activity-erp' => 'nullable|string', 
            
            'other-activity' => 'nullable|string|max:255',
        ]);
    
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = Auth::id();
        if (!$user_id) {
            // Rediriger si l'utilisateur n'est pas connecté
            return redirect()->route('login');
        }
        $typeActivity = $request->input('type-activite');
        // Récupérer l'activité sélectionnée
        if ($typeActivity == 1) {
            $specificActivity = $request->input('specific-activity-erp');
        } elseif ($typeActivity == 2) {
            $specificActivity = $request->input('specific-activity');
        }else {  $specificActivity = null ;}
        
        $specificActivityOption = $request->input('specific-activity-option');
        $otherActivity = $request->input('other-activity');

        if($typeActivity == 2 || $typeActivity == 1)
        {
            // Si l'utilisateur a sélectionné "Autre" et entré une activité, on utilise celle-ci
            if ($specificActivityOption == '0' && !empty($otherActivity)) {
                $specificActivity = $otherActivity;
            }  
        }


        Certificat::create([
            'id' => time(),
            'user_id' => $user_id,
            'nationalIdPath' => 'NULL',
            'legalAnnouncementPath' => 'NULL',
            'buildingOwnershipPath' => 'NULL',
            'buildingDiagramPath' => 'NULL',
            'residentialBuildingPath' => 'NULL',
            'licenseDecisionPath' => 'NULL',
            'gouvernorat' => $request->input('gouvernorat'),
            'delegation' => $request->input('delegation'),
            'type_activite' => $typeActivity, // Enregistre l'activité ou "Autre" activité
            'activity' => $specificActivity, // Enregistre l'activité ou "Autre" activité
            'statut' => 1,

       ]);
    
        return redirect()->back()->with('success', 'تم إرسال الطلب بنجاح!');
    }

    public function profile_prev(Request $request)
    {
        // Fetch all governorates from the database
        $governorates = \App\Models\Governorate::all();

        // Return the view with governorates passed to it
        return view('prev.prev', compact('governorates'));
    }


    public function download($id)
    {
        $certificat = Certificat::with('user')->findOrFail($id);
        // Generate QR code
        $qrCode = base64_encode(QrCode::format('svg')->size(200)->generate($certificat->hash));

        // 1) Render your Blade view as a string
        $html = view('certificats.pdf', [
            'certificat' => $certificat,
            'qrCode'     => $qrCode
        ])->render();

        // Create mPDF instance with Arabic support options
        $mpdf = new Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'autoLangToFont'    => true,   // Auto-detect language to use proper fonts
            'autoScriptToLang'  => true,   // Enable automatic script-to-language
        ]);

        // 3) Write the HTML, then output as download
        $mpdf->WriteHTML($html);
        return $mpdf->Output('certificate-' . $certificat->id . '.pdf', 'D');
    }

    // Show QR scanner form
    public function showScanForm()
    {
        return view('certificats.scan');
    }

    // Show certificate details from QR
    public function showDetailsQr(Request $request)
    {
        $hash = $request->input('hash');
        
        if (!$hash) {
            return redirect()->route('certificats.scan.form')
                ->with('error', 'QR code data missing');
        }

        $certificate = Certificat::with('user')
            ->where('hash', $hash)
            ->firstOrFail();

        return view('certificats.details', compact('certificate'));
    }



}