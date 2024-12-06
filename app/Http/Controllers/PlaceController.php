<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function getAll()
    {   
        $places = Place::all();
        if ($places->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron lugares',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Listado de lugares",
            'data' => $places
        ], 200);
    }

    public function getId($id)
    {
        $place = Place::find($id);
        if ($place) {
            return response()->json([
                'status' => 'success',
                'message' => 'Lugar encontrado',
                'data' => $place
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Lugar no encontrado'
        ], 404);
    }

    public function postOne(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'url_imagen' => 'required|string',
            'fecha_visita' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $place = Place::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'url_imagen' => $request->url_imagen,
            'fecha_visita' => $request->fecha_visita
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lugar creado con éxito',
            'data' => $place
        ], 201);
    }

    public function putchOne(Request $request, $id)
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
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400); 
            }

            // Actualizar solo si los valores han cambiado
            $place->nombre = $request->nombre;
            $place->direccion = $request->direccion;
            $place->url_imagen = $request->url_imagen;
            $place->fecha_visita = $request->fecha_visita;
            $place->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Lugar actualizado con éxito',
                'data' => $place
            ], 200); 
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Lugar no encontrado'
        ], 404);
    }

    public function deleteOne($id)
    {
        $place = Place::find($id);
        if ($place) {
            $place->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Lugar eliminado'
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Lugar no encontrado'
        ], 404);
    }
}
