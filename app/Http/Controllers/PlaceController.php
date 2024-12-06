<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function patchOne(Request $request, $id)
    {
        $place = Place::find($id);
        if ($place) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string',
                'direccion' => 'required|string',
                'url_imagen' => 'required|string',
                'fecha_visita' => 'required|date'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
            }

            $place->nombre = $request->nombre;
            $place->direccion = $request->direccion;
            $place->url_imagen = $request->url_imagen;
            $place->fecha_visita = $request->fecha_visita;
            $place->save();

            return response()->json($place); // Devolver los datos actualizados
        }

        return response()->json(['message' => 'Lugar no encontrado'], 404);
    }
}