<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicios;

class serviciosController extends Controller
{
    public function index(){
        $service = Servicios::all();
        return response()->json([
            'service' => $service,
            'message' => 'Servicios obtenidos correctamente'
        ]);
    }

    public function store(Request $request){
        $service = Servicios::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen_id' => $request->imagen_id,
            'precio' => $request->precio,
            'active' => $request->active
        ]);
        return response()->json([
            'service' => $service,
            'message' => 'Servicio guardado correctamente'
        ]);
    }

    public function show($id){
        $service = Servicios::find($id);
        return response()->json([
            'service' => $service,
            'message' => 'Servicio obtenido correctamente'
        ]);
    }

    public function update(Request $request, $id){
        $service = Servicios::find($id);
        $service->update($request->all());
        return response()->json([
            'service' => $service,
            'message' => 'Servicio actualizado correctamente'
        ]);
    }   

    public function destroy($id){
        $service = Servicios::find($id);
        $service->delete();
        return response()->json([
            'service' => $service,
            'message' => 'Servicio eliminado correctamente'
        ]);
    }
}
