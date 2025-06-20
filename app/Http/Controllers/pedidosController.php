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
            'message' => 'Pedidos obtenidos correctamente'
        ]);
    }

    public function store(Request $request){
        $pedido = Pedido::create([
            'nombre_cliente' => $request->nombre_cliente,
            'cedula' => $request->cedula,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'servicio_id' => $request->servicio_id,
            'monto' => $request->monto,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones
        ]);
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Pedido guardado correctamente'
        ]);
    }

    public function show($id){
        $pedido = Pedido::find($id);
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Pedido obtenido correctamente'
        ]);
    }

    public function update(Request $request, $id){
        $pedido = Pedido::find($id);
        $pedido->update($request->all());
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Pedido actualizado correctamente'
        ]);
    }   

    public function destroy($id){
        $pedido = Pedido::find($id);
        $pedido->delete();
        return response()->json([
            'pedido' => $pedido,
            'message' => 'Pedido eliminado correctamente'
        ]);
    }
}
