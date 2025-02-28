<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CertificatController;


use App\Http\Controllers\GovernorateController;

use App\Http\Controllers\FormControllerSubmit;


# Frontend Controllers
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StepController;

use App\Http\Controllers\requestShowAdmin;
use App\Http\Controllers\QRScannerController;

Route::get('/scan', [QRScannerController::class, 'scan'])->name('qrscanner.scan');
Route::get('/certificate/{hash}', [QRScannerController::class, 'showCertificate'])->name('qrscanner.show');


Route::get('/certificat/download/{id}', [CertificatController::class, 'download'])
     ->name('certificat.download');


// Public routes
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth'); // Only accessible to authenticated users

// Authenticated routes group
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Mark a single notification as read
    Route::post('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.mark-as-read');
        
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.mark-all-as-read');

    // View all notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');



    // yodkhel ken e super admin
    Route::get('/special', function () {
        return view('special'); // Create this view if needed
    })->middleware('can:super-admin')->name('special');

    // yodkher e service o super admin
    Route::get('/service', function () {
        return view('special'); // Create this view if needed
    })->middleware('can:service')->name('service');
});

// Authentication routes (login/register/password reset)
require __DIR__.'/auth.php';


Route::get('/test-notification', function() {
    notify(auth()->user(), 'Test Notification', 'This is a test notification', '/dashboard');
    return 'Notification sent!';
});


#Route::get('/test',[BackendTestController::class,'test']);
Route::get('/prev', [CertificatController::class,'profile_prev'])->name('prevontion');


Route::get('/certificats/{certificat}/details', [CertificatController::class, 'getDetails'])
     ->name('certificats.details')
     ->middleware('auth');

    
Route::get('/demande/{id}', [CertificatController::class, 'showDetails'])
     ->name('demande.show')
     ->middleware('auth');



Route::put('/certificat/validate-step/{id}', [CertificatController::class, 'validateStep'])
    ->name('certificat.validate.step');

Route::put('/certificat/validate-documents/{id}', [CertificatController::class, 'validateDocuments'])
    ->name('certificat.validate.documents');

Route::put('/certificat/{certificatId}/update-last-visite', [CertificatController::class, 'updateLastVisiteStatus'])
    ->name('certificat.update.last.visite');

Route::post('/certificat/nouveau', [CertificatController::class, 'createNewCertificat'])
    ->name('certificat.new');

Route::get('/requestprev', [requestShowAdmin::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('requestprev');

    Route::get('/management', [UserController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('management/users');


Route::get('/show_user/{id}', [UserController::class, 'show'])
    ->name('show_user');


Route::post('/update-user', [UserController::class, 'updateUser'])->name('update.user');


Route::get('/request/details/{id}', [CertificatController::class, 'showDetails'])->name('request.details');


Route::get('/certificat/{id}/visites', [CertificatController::class, 'showVisite'])->name('certificat.visites');
Route::post('/certificat/visite/store', [CertificatController::class, 'storeVisite'])->name('certificat.visite.store');

/* route step page */
Route::get('/steps', [StepController::class, 'index'])->name('steps.index');
Route::post('/steps', [StepController::class, 'store'])->name('steps.store');

Route::get('/user/certificats/{certificat}', [UserController::class, 'showCertificat'])
     ->name('user.certificats.show');


// Afficher le formulaire de sélection des documents
Route::get('/certificats/{certificat}/documents', [CertificatController::class, 'showDocumentSelection'])
     ->name('certificats.documents');

// Enregistrer les documents sélectionnés
Route::post('/certificats/{certificat}/documents', [CertificatController::class, 'storeDocuments'])
     ->name('certificats.store-documents');

/* route pour details de demande certif */
Route::get('/demande/{id}', function ($id) {
    return view('front.pages.demande', ['id' => $id]);
})->name('demande.show');

Route::get('/certificat/{id}', [CertificatController::class, 'show'])->name('certificat.show');


#route pour telecharger les ficher 
Route::get('/telechargement', function () {
    return view('download'); // Correspond au fichier `resources/views/download.blade.php`
});
// Afficher le formulaire de demande de certificat
Route::get('/demande-certificat', [CertificatController::class, 'showForm'])->name('certificat.form');

// Traiter la soumission du formulaire de demande de certificat
Route::post('/demande-certificat', [CertificatController::class, 'submitForm'])->name('certificat.submit');
Route::post('/submit-certificat', [CertificatController::class, 'submitForm'])
     ->name('certificat.submit');


Route::get('/get-delegations', [GovernorateController::class, 'getDelegations']);

use App\Http\Controllers\FormationController;

Route::get('/formation', [FormationController::class, 'create'])->name('formation.create');
Route::post('/formation', [FormationController::class, 'store'])->name('formation.store');
Route::get('/demandes', [FormationController::class, 'index'])->name('demandes.index');
Route::get('/demandes/{id}/details', [FormationController::class, 'details'])->name('demandes.details');
// Route pour les détails des demandes d'une formation spécifique
Route::get('/formations/{formation}/requests', [FormationController::class, 'manageRequests'])
     ->name('formations.requests');

Route::get('/requestformation', [FormationController::class, 'showRequests'])
     ->name('formations.list');
Route::post('/formation/creation', [FormationController::class, 'creationFormation'])
     ->name('formation.creation');

Route::post('/formations/{formation}/confirmer', [FormationController::class, 'confirmeFormation'])
     ->name('formations.confirme');

Route::post('/formations/{formation}/refuser', [FormationController::class, 'refuseFormation'])
     ->name('formations.refuse');

Route::get('/certificats/{id}/details', [CertificatController::class, 'showDetails2'])->name('certificat.details');

Route::get('/demandes', [FormationController::class, 'index'])->name('formation.index');
Route::get('/demandes/{id}/details', [FormationController::class, 'details'])->name('formation.details');    