<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StepController extends Controller
{
    public function index()
    {
        // Retourne la vue step.blade.php située dans resources/views/front/pages/
        return view('front.pages.step');
    }
}