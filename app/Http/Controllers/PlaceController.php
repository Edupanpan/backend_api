<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    /**
     * Obtener todos los lugares.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {   
        $places = Place::all();

        if ($places->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron lugares',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => "Listado de lugares",
            'data' => $places
        ], 200);
    }

    /**
     * Obtener un lugar por su ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getId($id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'message' => 'Lugar no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Lugar encontrado',
            'data' => $place
        ], 200);
    }

    /**
     * Crear un nuevo lugar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postOne(Request $request)
    {   
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'url_imagen' => 'required|string',
            'fecha_visita' => 'required|date',
        ]);

        // Si la validación falla, se retornan los errores
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el lugar
        $place = Place::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'url_imagen' => $request->url_imagen,
            'fecha_visita' => $request->fecha_visita,
        ]);

        // Verificar si se creó correctamente
        if (!$place) {
            return response()->json([
                'message' => 'Error al crear el lugar'
            ], 500);
        }

        return response()->json([
            'message' => 'Lugar creado con éxito',
            'data' => $place
        ], 201);
    }

    /**
     * Actualizar un lugar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putchOne(Request $request, $id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'message' => 'Lugar no encontrado'
            ], 404);
        }

        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'url_imagen' => 'required|string',
            'fecha_visita' => 'required|date',
        ]);

        // Si la validación falla, se retornan los errores
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Actualizar el lugar
        $place->nombre = $request->nombre;
        $place->direccion = $request->direccion;
        $place->url_imagen = $request->url_imagen;
        $place->fecha_visita = $request->fecha_visita;
        $place->save();

        return response()->json([
            'message' => 'Lugar actualizado con éxito',
            'data' => $place
        ], 200);
    }

    /**
     * Eliminar un lugar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteOne($id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'message' => 'Lugar no encontrado'
            ], 404);
        }

        // Eliminar el lugar
        $place->delete();

        return response()->json([
            'message' => 'Lugar eliminado con éxito'
        ], 200);
    }
}
