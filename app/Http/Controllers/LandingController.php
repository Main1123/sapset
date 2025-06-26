<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio; 
use App\Models\Imagene;

class LandingController extends Controller
{
    public function index()
    {
        // Asegúrate de que la relación 'imagene' se está cargando
        $servicios = Servicio::with('imagene')->where('active', 1)->get();
        $imagenes = Imagene::all();

        return view('landing.landing', compact('servicios', 'imagenes'));
    }
}