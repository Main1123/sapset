<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\imagenes;

class imagenesController extends Controller
{
   public function index(){
    $imagenes = imagenes::all();
    return response()->json([
        'imagenes' => $imagenes,
        'message' => 'Imagenes obtenidas correctamente'
    ]);
   }

   public function store(Request $request){
    $imagenes = imagenes::create([
        'path' => $request->path,
        'filename' => $request->filename,
        'section' => $request->section
    ]);
    return response()->json([
        'imagenes' => $imagenes,
        'message' => 'Imagen guardada correctamente'
    ]);
   }

   public function show($id){
    $imagen = imagenes::find($id);
    return response()->json([
        'imagen' => $imagen,
        'message' => 'Imagen obtenida correctamente'
    ]);
   }

   public function update(Request $request, $id){
    $imagen = imagenes::find($id);
    $imagen->update($request->all());
    return response()->json([
        'imagen' => $imagen,
        'message' => 'Imagen actualizada correctamente'
    ]);
   }

   public function destroy($id){
    $imagen = imagenes::find($id);
    $imagen->delete();
    return response()->json([
        'imagen' => $imagen,
        'message' => 'Imagen eliminada correctamente'
    ]);
   }
}
