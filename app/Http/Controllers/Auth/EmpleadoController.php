<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Empleado;
use BolsaTrabajo\Cargo;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    public function index()
    {
        $cargo = Cargo::all();
        return view('auth.empleado.index' , compact('cargo'));
    }

    public function list_all()
    {
        try {
            // Obtener todos los empleados, incluyendo la información del cargo
            $empleados = Empleado::with('cargo')->orderby('id', 'desc')->get();
    
            return response()->json(['data' => $empleados], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los empleados.'], 500);
        }
    }


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'dni' => 'required|string|max:20|unique:empleados,dni',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cargo_id' => 'required|exists:cargos,id', // Asumiendo que 'cargos' es otra tabla
        ]);

        // Crear un nuevo empleado
        $empleado = Empleado::create($request->only([
            'dni', 'nombre', 'apellido', 'cargo_id', 'tel', 'email'
        ]));

        // Redirigir o responder con éxito
        return redirect()->route('auth.empleado')->with('success', 'Empleado creado exitosamente.');
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Empleado::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }

    public function partialView($id)
    {
        $cargo = Cargo::all();
        $Entity = Empleado::find($id);
        return view('auth.empleado._Editar', ['cargo' => $cargo,'Entity' => $Entity]);
    }


    public function get($id)
    {
        try {
            $empleado = Empleado::with('cargo')->findOrFail($id);
            return response()->json($empleado, 200);
        } catch (\ModelNotFoundException $e) {
            return response()->json(['error' => 'Empleado no encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el empleado.'], 500);
        }
    }


    public function update(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = Empleado::find($request->id);
            $entity->dni = $request->dni;
            $entity->nombre = $request->nombre;
            $entity->apellido = $request->apellido;
            $entity->cargo_id = $request->cargo_id;
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            $entity->estado = $request->estado;

            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }



}
