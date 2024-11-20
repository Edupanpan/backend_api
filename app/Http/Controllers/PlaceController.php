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
            return response()->json(['message' => 'Lugar encontrado', 'data' => $place]);
        }
        return response()->json(['message' => 'Lugar no encontrado'], 404);
    }
    

    public function postOne(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'fecha_visita' => 'required|date',
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'imagen' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()]);
        }

        $places = Place::create(
        ['fecha_visita'=>$request->fecha_visita,
        'nombre'=>$request->nombre,
        'direccion'=>$request->direccion,
        'imagen'=>$request->imagen]);
        if(!$places){
            $data=[
                'message'=>'Error al crear el lugar'
            ];
            return response()->json($data);
        }
        $data=[
            'message'=>'Lugar creado',
            'data'=>$places
        ];
        return response()->json($data);
            
    }
    public function putchOne(Request $request, $id)
    {
        $place = Place::find($id);
        if ($place) {
                $validator = Validator::make($request->all(), [
                    'fecha_visita' => 'required|date',
                    'nombre' => 'required|string',
                    'direccion' => 'required|string',
                    'imagen' => 'required|string'
                ]);
                if  ($validator->fails()) {
                    return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()]);
                }
                $place->fecha_visita = $request->fecha_visita;
                $place->nombre = $request->nombre;
                $place->direccion = $request->direccion;
                $place->imagen = $request->imagen;
                $place->save();
                return response()->json(['message' => 'Lugar actualizado', 'data' => $place]);
        }
        return response()->json(['message' => 'Lugar no encontrado'], 404);
     
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