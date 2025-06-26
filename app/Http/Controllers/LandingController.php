<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio; // Importa tu modelo Servicio

class LandingController extends Controller
{
    public function index()
    {
        // Asegúrate de que la relación 'imagene' se está cargando
        $servicios = Servicio::with('imagene')->where('active', 1)->get();

        return view('landing.landing', compact('servicios'));
    }
}