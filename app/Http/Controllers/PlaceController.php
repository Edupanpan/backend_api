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
            $data = [
                'message' => 'No se encontraron lugares',
            ];
            return response()->json($data);
        }
        $data = [
            'message' => "Listado de lugares",
            'data' => $places
        ];
        return response()->json($data);
    }
    public function getId($id)
    {
        $place = Place::find($id);
        if ($place) {
            return response()->json([$place]);
        }
        return response()->json(['message' => 'Lugar no encontrado'], 404);
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
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        $places = Place::create(
            ['nombre'=>$request->nombre,
            'direccion'=>$request->direccion,
            'url_imagen'=>$request->url_imagen,
            'fecha_visita'=>$request->fecha_visita]);
        if(!$places){
            $data=[
                'message'=>'Error al crear el lugar'
            ];
            return response()->json($data);
        }
        return response()->json($places);
            
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
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400); 
        }


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
    return response()->json([
        'message' => 'Lugar no encontrado'
    ], 404);
}

    
    
    public function deleteOne($id)
    {
        $place = Place::find($id);
        if ($place) {
            $place->delete();
            return response()->json(['message' => 'Lugar eliminado']);
        }
        return response()->json(['message' => 'Lugar no encontrado'], 404);
    }
}