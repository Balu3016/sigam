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

        // 3. Conteo de entregas agrupadas por nombre de Localidad para alimentar el mapa
        $puntosMapa = DB::table('entregas')
            ->join('beneficiarios', 'entregas.beneficiario_id', '=', 'beneficiarios.id')
            ->join('localidades', 'beneficiarios.localidad_id', '=', 'localidades.id')
            ->select('localidades.nombre as localidad', DB::raw('count(entregas.id) as total'))
            ->groupBy('localidades.nombre')
            ->pluck('total', 'localidad')
            ->map(function ($total) {
                return ['total' => $total];
            });

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