<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.landing');
    }

    public function servicios(){
        $servicios = Servicio::all();
        return response()->json($servicios);
    }
}
