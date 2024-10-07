<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Inicio;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Programa;
use BolsaTrabajo\Participantes;
use BolsaTrabajo\Alumno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InicioController extends Controller
{
        public function index(Request $request)
        {
            $fechaDesde = $request->input('fecha_desde', "2000-01-01");
            $fechaHasta = $request->input('fecha_hasta', Carbon::now()->addDay()->format('Y-m-d'));
        
            // Obtener datos filtrados por fechas
            $totalEmpleados = $this->getTotalDeEmpleados($fechaDesde, $fechaHasta);

        
            $getTopFaltasPorEmpleado = $this->getTopFaltasPorEmpleado($fechaDesde, $fechaHasta);

        
            // Pasar los datos a la vista 'auth.inicio.index'
            if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR ||
                Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_ADMINISTRADOR ||
                Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_LIDER
                ) {
                return view('auth.inicio.index', compact('totalEmpleados', 'getTopFaltasPorEmpleado',
                    'fechaDesde', 'fechaHasta'));
            }
        
            return redirect('/auth/error'); // Redirige a una página predeterminada si la condición no se cumple
        }
    

        /* Indicadores */
        private function getTotalDeEmpleados($fecha_desde, $fecha_hasta)
        {
            return DB::table('empleados')
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->where('estado', '1') 
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        }
    
       /*  private function getTotalCelulas($fecha_desde, $fecha_hasta)
        {
            return DB::table('celulas')
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->where('estado', '=', 1) // Filtrar por estado igual a 1
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        }
    
    
        private function getTotalActividades($fecha_desde, $fecha_hasta)
        {
            return DB::table('calendarios')
                ->where('estado', '=', 1) // Filtrar por estado igual a 1
                ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
                ->whereNull('deleted_at') // no contar con los eliminados
                ->count();
        } */
    
        // primer grafico
        private function getTopFaltasPorEmpleado($fecha_desde, $fecha_hasta)
        {
            return DB::table('asistencias as a')
                ->whereBetween('a.created_at', [$fecha_desde, $fecha_hasta])
                ->join('empleados as e', 'a.dni', '=', 'e.dni')
                ->where('a.hora_entrada', '>', '08:05') // Tardanza o falta
                ->where('estado', '1') 
                ->whereNull('a.deleted_at') // Excluye asistencias eliminadas
                ->selectRaw('e.dni as empleado, e.nombre, COUNT(*) as faltas')
                ->groupBy('e.dni', 'e.nombre')
                ->orderBy('faltas', 'desc')
                ->limit(10)
                ->get();
        }

        




        


        


        
}