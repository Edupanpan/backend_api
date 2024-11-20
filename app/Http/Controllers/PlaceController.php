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
    public function getId(){
        return"hola";
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
    public function putchOne(Request $request)
    {
        return"esto deberia actualizar un dato en la base de datos";
    }
    public function deleteOne(Request $request)
    {
        return"esto deberia eliminar un dato en la base de datos";
    }
}