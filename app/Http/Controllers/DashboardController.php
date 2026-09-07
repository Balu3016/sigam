<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiario;
use App\Models\Entrega;
use App\Models\ProgramaSocial;
use App\Models\Localidad;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Muestra la vista principal del Dashboard con las métricas y datos del mapa.
     */
    public function index()
    {
        // 1. Conteos Totales para los KPIs
        $totalBeneficiarios = Beneficiario::count();
        $totalEntregas      = Entrega::count();
        $totalProgramas     = ProgramaSocial::count();
        $totalLocalidades   = Localidad::count();

        // 2. Últimas 5 entregas realizadas (con sus relaciones)
        $ultimasEntregas = Entrega::with(['beneficiario.localidad', 'programaSocial'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Puntos exactos de entregas guardados con geolocalización directa
        $puntosMapa = DB::table('entregas')
            ->leftJoin('beneficiarios', 'entregas.beneficiario_id', '=', 'beneficiarios.id')
            ->leftJoin('localidades', 'entregas.localidad_id', '=', 'localidades.id')
            ->leftJoin('programas_sociales', 'entregas.programa_social_id', '=', 'programas_sociales.id')
            ->select(
                'entregas.id',
                'entregas.latitud',
                'entregas.longitud',
                'beneficiarios.nombre as beneficiario',
                'localidades.nombre as localidad',
                'programas_sociales.nombre as programa'
            )
            ->whereNotNull('entregas.latitud')
            ->whereNotNull('entregas.longitud')
            ->get();

        return view('dashboard', compact(
            'totalBeneficiarios',
            'totalEntregas',
            'totalProgramas',
            'totalLocalidades',
            'ultimasEntregas',
            'puntosMapa'
        ));
    }
}