<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Pedido;
use App\Models\Imagene;

class DashboardController extends Controller
{
    public function index()
    {
        $totalServicios = Servicio::where('active', 1)->count();
        $pedidosPendientes = Pedido::where('estado', 'pendiente')->count();
        $imagenesCargadas = Imagene::count();

        return view('admin.home', compact('totalServicios', 'pedidosPendientes', 'imagenesCargadas'));
    }
}