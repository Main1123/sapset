<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;

class ConfiguracionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $configuraciones = Configuracion::all();
        return view('admin.configuraciones.index', compact('configuraciones'));
    }

    public function create()
    {
        return view('admin.configuraciones.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:configuraciones',
            'valor' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        Configuracion::create($request->all());

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración creada exitosamente');
    }

    public function edit(Configuracion $configuracion)
    {
        return view('admin.configuraciones.form', compact('configuracion'));
    }

    public function update(Request $request, Configuracion $configuracion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:configuraciones,nombre,' . $configuracion->id,
            'valor' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
        ]);

        $configuracion->update($request->all());

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración actualizada exitosamente');
    }

    public function destroy(Configuracion $configuracion)
    {
        $configuracion->delete();

        return redirect()->route('admin.configuraciones.index')
            ->with('success', 'Configuración eliminada exitosamente');
    }
}
