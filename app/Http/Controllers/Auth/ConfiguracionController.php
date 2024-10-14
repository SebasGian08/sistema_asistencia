<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Configuracion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return view('auth.configuracion.index');
    }

    public function list_all()
    {
        return response()->json(['data' => Area::orderby('id', 'desc')->get()]);
    }

    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = Area::find($id);

        return view('auth.area._Mantenimiento', ['Entity' => $entity]);
    }

    public function store(Request $request)
    {
        $status = false;

        if($request->id != 0)
            $entity = Configuracion::find($request->id);
        else
            $entity = new Configuracion();

        $validator = Validator::make($request->all(), [
            'numero' => 'required|numero',
        ]);

        if (!$validator->fails()){
            $entity->numero = trim($request->numero);
            if($entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Area::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }
}
