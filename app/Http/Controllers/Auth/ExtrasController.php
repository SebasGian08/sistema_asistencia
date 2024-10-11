<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Extras;
use BolsaTrabajo\Empleado;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExtrasController extends Controller
{
    public function index()
    {
        return view('auth.extras.index');
    }

    public function list_all()
    {
        $extras = Extras::with('empleado:id,dni,nombre,apellido')
            ->orderby('id', 'desc')
            ->get();

        return response()->json(['data' => $extras]);
    }


    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = Extras::find($id);

        return view('auth.extras._Editar', ['Entity' => $entity]);
    }

    public function store(Request $request)
    {
        $status = false;

        if($request->id != 0)
            $entity = Extras::find($request->id);
        else
            $entity = new Area();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:areas,nombre,'.($request->id != 0 ? $request->id : "NULL").',id,deleted_at,NULL'
        ]);

        if (!$validator->fails()){
            $entity->nombre = trim($request->nombre);
            if($entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Extras::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }

    public function update(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Extras::find($request->id);
            $entity->estado = $request->estado;


            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }
}
