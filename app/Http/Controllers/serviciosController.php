<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    public function index(){
        try {
            $services = Servicio::with('imagene')->get();
            return response()->json([
                'services' => $services,
                'message' => 'Servicios obtenidos correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al obtener los servicios: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request){
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'active' => 'required|boolean',
            'imagen_id' => 'nullable|exists:imagenes,id'
        ]);

        try {
            $service = Servicio::create($validated);
            return response()->json([
                'service' => $service,
                'message' => 'Servicio guardado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al guardar el servicio: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id){
        try {
            $service = Servicio::with('imagene')->find($id);
            if (!$service) {
                return response()->json([
                    'error' => true,
                    'message' => 'Servicio no encontrado'
                ], 404);
            }
            return response()->json([
                'service' => $service,
                'message' => 'Servicio obtenido correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al obtener el servicio: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id){
        $validated = $request->validate([
            'titulo' => 'string|max:255',
            'descripcion' => 'string',
            'precio' => 'numeric|min:0',
            'active' => 'boolean',
            'imagen_id' => 'nullable|exists:imagenes,id'
        ]);

        try {
            $service = Servicio::find($id);
            if (!$service) {
                return response()->json([
                    'error' => true,
                    'message' => 'Servicio no encontrado'
                ], 404);
            }
            $service->update($validated);
            return response()->json([
                'service' => $service,
                'message' => 'Servicio actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al actualizar el servicio: ' . $e->getMessage()
            ], 500);
        }
    }   

    public function destroy($id){
        try {
            $service = Servicio::find($id);
            if (!$service) {
                return response()->json([
                    'error' => true,
                    'message' => 'Servicio no encontrado'
                ], 404);
            }
            $service->delete();
            return response()->json([
                'message' => 'Servicio eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error al eliminar el servicio: ' . $e->getMessage()
            ], 500);
        }
    }
}
