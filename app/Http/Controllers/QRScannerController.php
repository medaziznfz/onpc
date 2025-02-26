<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificat;

class QRScannerController extends Controller
{
    /**
     * Show the QR scanner page.
     */
    public function scan()
    {
        return view('qrscanner.scan');
    }

    /**
     * Show the certificate details after scanning.
     */
    public function showCertificate($hash)
    {
        $certificate = Certificat::where('hash', $hash)->first();

        return view('qrscanner.certificate_details', compact('certificate'));
    }
}
