<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagene;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImagenesController extends Controller
{
    public function index()
    {
        $imagenes = Imagene::all();
        return response()->json([
            'imagenes' => $imagenes,
            'message' => 'Imagenes obtenidas correctamente'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('path')) {
            try {
                $imagePath = $request->file('path')->store('img', 'public'); // Usar 'img'
            } catch (\Exception $e) {
                Log::error('Error al guardar la imagen en el storage: ' . $e->getMessage());
                return response()->json(['message' => 'Error al guardar el archivo de imagen.'], 500);
            }
        } else {
            return response()->json(['message' => 'No se ha subido ninguna imagen.'], 400);
        }

        $imagen = Imagene::create([
            'path' => $imagePath,
            'filename' => $request->filename,
            'section' => $request->section
        ]);

        return response()->json([
            'imagen' => $imagen,
            'message' => 'Imagen guardada correctamente'
        ], 201);
    }

    public function show($id)
    {
        $imagen = Imagene::find($id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada'], 404);
        }
        return response()->json([
            'imagen' => $imagen,
            'message' => 'Imagen obtenida correctamente'
        ]);
    }

    public function update(Request $request, $imagen_id)
    {
        $imagen = Imagene::find($imagen_id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada para actualizar'], 404);
        }

        $request->validate([
            'filename' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('path')) {
            if ($imagen->path && Storage::disk('public')->exists($imagen->path)) {
                Storage::disk('public')->delete($imagen->path);
            }

            try {
                $imagePath = $request->file('path')->store('img', 'public');
                $imagen->path = $imagePath;
            } catch (\Exception $e) {
                Log::error('Error al actualizar la imagen en el storage: ' . $e->getMessage());
                return response()->json(['message' => 'Error al actualizar el archivo de imagen.'], 500);
            }
        }

        $imagen->filename = $request->filename;
        $imagen->section = $request->section;
        $imagen->save();

        return response()->json([
            'imagen' => $imagen,
            'message' => 'Imagen actualizada correctamente'
        ]);
    }

    public function destroy($id)
    {
        $imagen = Imagene::find($id);
        if (!$imagen) {
            return response()->json(['message' => 'Imagen no encontrada para eliminar'], 404);
        }

        // Si la ruta en la DB está guardada con 'img/', se eliminará correctamente.
        // Si tienes registros viejos con 'imagenes/', es posible que no los encuentre.
        if ($imagen->path && Storage::disk('public')->exists($imagen->path)) {
            try {
                Storage::disk('public')->delete($imagen->path);
            } catch (\Exception $e) {
                Log::error('Error al eliminar la imagen del storage: ' . $e->getMessage());
                return response()->json(['message' => 'Error al eliminar el archivo físico de la imagen.'], 500);
            }
        }

        $imagen->delete();
        return response()->json([
            'message' => 'Imagen eliminada correctamente'
        ]);
    }
}