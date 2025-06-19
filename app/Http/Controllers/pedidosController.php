<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class pedidosController extends Controller
{
    public function index(){
        $pedido = Pedido::all();
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Servicios obtenidos correctamente'
        ]);
    }

    public function store(Request $request){
        $pedido = Pedido::create([
            'titulo' => $request->nombre_cliente,
            'descripcion' => $request->email,
            'imagen_id' => $request->telefono,
            'precio' => $request->direccion,
            'active' => $request->servicio,
            'monto' => $request->monto,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones
        ]);
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Servicio guardado correctamente'
        ]);
    }

    public function show($id){
        $pedido = Pedido::find($id);
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Servicio obtenido correctamente'
        ]);
    }

    public function update(Request $request, $id){
        $pedido = Pedido::find($id);
        $pedido->update($request->all());
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Servicio actualizado correctamente'
        ]);
    }   

    public function destroy($id){
        $pedido = Pedido::find($id);
        $pedido->delete();
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Servicio eliminado correctamente'
        ]);
    }
}
